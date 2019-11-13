#install.packages(c("RODBC","CRossVA","openVA","nbc4va"))
#load required packages
rm(list = ls())
getwd()
wd = paste(getwd(),"/dashboard", sep="")
csvloc = paste(getwd(),"/OpenVAFiles/openVA_input.csv", sep="")

#what to change
mal_prev='h'
hiv_prev='h'



#library("RODBC")
library("CrossVA")
library("openVA")
library('nbc4va')
library('stringi')
library('stringr')
library('plyr')


#remove everything in environment

setwd(wd)
if(dir.exists("datasets")){
  
}else{
  dir.create("datasets")
}

if(file.exists("merged_cod_va.csv")){
  merged = read.csv("merged_cod_va.csv", stringsAsFactors = F)
}else{
  mat = as.matrix(".")
  merged = as.data.frame(mat) 
  colnames(merged)=c("meta.instanceID")
}

vadata = read.csv("vadata.csv", stringsAsFactors = F)
header= names(vadata)
header_cleaned <- regmatches(header, regexpr("[^\\.]*$", header))
colnames(vadata)=c(tolower(header_cleaned))


#exclude already existing VAs
vadata = vadata[which(!(vadata$instanceid %in% merged$ID)),]

ne = c('id10082','id10189','id10315','id10362','id10412','id10184_units','id10190_units')
if (length(which(ne %in% names(vadata))) != length(ne) ){
  vadata[which(!(ne %in% names(vadata)))]='.'
}

#remove blank VAs
vadatacl= vadata[which(vadata$id10013=='yes'),]

if(dim(vadatacl)[1]<=1){
  #no data to process
}else{
  #data to process found
    #vadatacl[is.na(vadatacl)]='.'
    num_nova= dim(vadata)[1] - dim(vadatacl)[1]
    
    vadatacl$ageindays[which(is.na(vadatacl$ageindays))] = 0
    vadatacl$ageinyears2[which(is.na(vadatacl$ageinyears2))] = 0
    
    #run interva and insilico data conversion and mapping
    #vadata_int = Converter(vadatacl)
    vadatacl["meta.instanceID"] = vadatacl$instanceid
    
    
    vadata_int = odk2openVA_v151(vadatacl)
    #vadata_int = va
    unique(unlist(vadata_int[,2:ncol(vadata_int)]))
    
    #write the output to CSV
    write.csv(vadata_int, row.names = F, "vadata_mapped.csv")
    
    vadata_int[which(!(vadata_int$ID %in% merged$meta.instanceID)),]
    
    #run interva COD
    fit_int = codeVA(vadata_int,data.type = "WHO2016", model = "InterVA",directory=".",file="cod_int5_gp",
                     Malaria = mal_prev, HIV = hiv_prev,version = "5.0",output="extended",
                     groupcode=F)
    
    cod_int = read.csv("cod_int5_gp.csv", stringsAsFactors = F)
    cod_int = cod_int[,c('ID','MALPREV','HIVPREV','CAUSE1','LIK1','CAUSE2','LIK2','COMCAT','COMNUM')]
    #View(head(cod_int))
    cod_int$CAUSE1[which(cod_int$CAUSE1==' ')]='Indeterminate'
    cod_int$CAUSE1 = trimws(cod_int$CAUSE1)
    
    icd10 = read.csv("icd10.csv", stringsAsFactors = F)
    icd10 = icd10[,c('interva5_cod','interva5_cod_orign','ICD.10_code_to_ICD')]
     
    #View(head(icd10))
    
    cod_va = merge(cod_int,vadatacl, by.x = "ID", by.y = "instanceid")
    #View(head(cod_va))
    
    
    cod_va$CAUSE1[which(cod_va$CAUSE1=='Reproductive neoplasms MF' &cod_va$id10019=='female')]='Female reproductive neoplasms'
    cod_va$CAUSE1[which(cod_va$CAUSE1=='Reproductive neoplasms MF' &cod_va$id10019=='male')]='Male reproductive neoplasms'
    
    #paste(icd10$autopsy_code,icd10$Verbal_autopsy_title)
    #icd10$iv5 = str_replace_all(paste(icd10$autopsy_code,icd10$Verbal_autopsy_title),'VAs-','')
    #icd10$iv5=trimws(icd10$iv5)
    #icd10$iv5 = str_replace_all(icd10$iv5,'  ',' ')
    #cod_va$CAUSE1=trimws(cod_va$CAUSE1)
    
    #icd10$iv5
    #cod_va$CAUSE1
    
    cod_va2 = merge(icd10,cod_va, by.x = "interva5_cod_orign",by.y = "CAUSE1")
    colnames(cod_va2)[which(stri_endswith_fixed(colnames(cod_va2),'cause_icd10'))] =c('cause_icd10_int')
    
    colnames(cod_va2)[which(stri_endswith_fixed(colnames(cod_va2),'interva5_cod'))] =c('interva5')
    
    #View(cod_va[which(!(cod_va$ID %in% cod_va2$ID)),])
    #View(cod_va$CAUSE1[which(!(tolower(cod_va$CAUSE1) %in% tolower(icd10$interva5_cod_orign)))])
    
    #View(head(cod_va2))
    cod_va2["cause_icd10_int"] = paste(cod_va2$ICD.10_code_to_ICD,cod_va2$interva5_cod_orign)
    cod_va2$ICD.10_code_to_ICD=NULL
    cod_va2$interva5_cod_orign=NULL
    write.csv(cod_va2, row.names = F, "va_icd_cod.csv")
    
    cod_va2= read.csv("va_icd_cod.csv", stringsAsFactors = F)
    viewva = cod_va2[,c("ID","interva5","cause_icd10_int","id10004","id10019","ageindays",
                        "ageinyears","isadult" ,"ischild", "isneonatal","age_group")]
    
  
    viewva$interva5 = trimws(viewva$interva5)
    viewva$cause_icd10_int = trimws(viewva$cause_icd10_int)
    write.csv(viewva,"va_subsetFin.csv",row.names = F)
    
    #ANALYSIS
    viewva['icd10_csmf']="."
    viewva$icd10_csmf = viewva$interva5
    
    csmf = as.data.frame(table(viewva$icd10_csmf))
    colnames(csmf)=c('cod','freq')
    
    
    #View(sort(table(cod_va2$cause_icd10_int), decreasing = T))
    write.csv(csmf,"datasets/general_csmf.csv",row.names = F)
    
    
    ###check all have ageGroups
    viewva['ageGroup'] = '.'
    viewva$ageGroup[which(viewva$isadult=='1')]='adult'
    viewva$ageGroup[which(viewva$ischild=='1')]='child'
    viewva$ageGroup[which(viewva$isneonatal=='1')]='neonatal'
    viewva$ageGroup[which(viewva$ageGroup =='.')]= viewva$age_group[which(viewva$ageGroup =='.')]
    viewva$ageGroup[which(viewva$ageGroup =='.')] #confirm all have agegroup
    deathsageGroup =as.data.frame(table(viewva$ageGroup))
    write.csv(deathsageGroup,"datasets/ageGroupDist.csv",row.names = F)
    
    ##by sex
    csmfSex =as.data.frame(table(viewva$id10019))
    write.csv(csmfSex,"datasets/csmfSex.csv",row.names = F)
    
    ##csmf Adults
    csmfAdult = as.data.frame(table(viewva$icd10_csmf[which(viewva$ageGroup=='adult')]))
    write.csv(csmfAdult,"datasets/csmfAdults.csv",row.names = F)
    
    
    ##csmf child
    csmfChild = as.data.frame(table(viewva$icd10_csmf[which(viewva$ageGroup=='child')]))
    write.csv(csmfChild,"datasets/csmfChild.csv",row.names = F)
    
    
    ##csmf neonate
    csmfNeonatal = as.data.frame(table(viewva$icd10_csmf[which(viewva$ageGroup=='neonatal')]))
    write.csv(csmfNeonatal,"datasets/csmfNeonatal.csv",row.names = F)
    
    ##csmf females
    csmfMales = as.data.frame(table(viewva$icd10_csmf[which(viewva$id10019=='male')]))
    write.csv(csmfMales,"datasets/csmfMales.csv",row.names = F)
    
    
    ##csmf males
    csmfFemales = as.data.frame(table(viewva$icd10_csmf[which(viewva$id10019=='female')]))
    write.csv(csmfFemales,"datasets/csmfFemales.csv",row.names = F)
    
    ##csmf by sex 
    tsex = table(viewva[,c('icd10_csmf','id10019')])
    tsex = as.data.frame.matrix(tsex)
    write.csv(tsex, row.names = T,"datasets/csmfBySex.csv")
    
    tag = table(viewva[,c('icd10_csmf','ageGroup')])
    tag = as.data.frame.matrix(tag)
    write.csv(tag, row.names = T,"datasets/csmfByAgeGroups.csv")
    
    
    ##indeterminate by inteviwer
    indet = cod_va2[which(cod_va2$interva5_cod_orign=='Indeterminate'),]
    indetint = as.data.frame(table(indet$id10010))
    write.csv(indetint, row.names = T,"datasets/indeterminate.csv")
    
    #rub insilico COD
    vadata_ins =vadata_int
    colnames(vadata_ins) = tolower(colnames(vadata_ins))
    fit_ins = codeVA(vadata_ins,data.type = "WHO2016", model = "InSilicoVA",directory=".",
                     Nsim = 4000 ,Malaria = mal_prev, HIV = hiv_prev)
    
    #getIndivProb()
    ins_cod = getTopCOD(fit_ins)
    ins_col = c("ID","Insilico")
    colnames(ins_cod) = ins_col
    write.csv(ins_cod, file="topcod_ins.csv",row.names = F)
    ins_cod$Insilico = as.character(ins_cod$Insilico)
    
    cod_va2$ID = NULL
    merge_cod = merge(ins_cod,cod_va2,by.x = "ID", by.y = "meta.instanceID")
    merge_cod$Insilico[which(merge_cod$Insilico=='Reproductive neoplasms MF' & 
                             merge_cod$id10019=='female')]='Female reproductive neoplasms'
    merge_cod$Insilico[which(merge_cod$Insilico=='Reproductive neoplasms MF' & 
                             merge_cod$id10019=='male')]='Male reproductive neoplasms'
    merge_cod$ID.y=NULL
    
    icd_ins = merge(icd10,merge_cod, by.x = "interva5_cod_orign",by.y = "Insilico")
    icd_ins$Insilico = icd_ins$interva5_cod_orign
    icd_ins["cause_icd10_ins"] = paste(icd_ins$ICD.10_code_to_ICD,icd_ins$Insilico)
    icd_ins$ICD.10_code_to_ICD=NULL
    icd_ins$interva5_cod_orign=NULL
    icd_ins$interva5_cod=NULL
    
    
    
    #re-order columns for insilico COD
    merge_cod2 = icd_ins[,c(1,ncol(icd_ins),ncol(icd_ins)-1,ncol(icd_ins)-2,2:(ncol(icd_ins)-3))]
 
    #READ THE TWO OUTPUTS FROM INTERVA AND INSILICO
    #interVACOD = read.csv("cod_int.csv", stringsAsFactors = F)
    #InsilicoCOD = read.csv("cod_ins.csv", stringsAsFactors = F)
    if(file.exists("merged_cod_va.csv")){
      fin = rbind.fill(merged,merge_cod2)
    }else{
      fin = merge_cod2
    }
    
    #write output to file
    write.csv(fin, file="merged_cod_va.csv",row.names = F)
}



