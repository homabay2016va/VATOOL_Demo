#install.packages("devtools")

#remove everything in environment
rm(list = ls())
setwd("C:\\Users\\Administrator\\Desktop\\OpenVAPipeline")

Sys.unsetenv("JAVA_HOME")
Sys.setenv("JAVA_HOME" = "C:\\Program Files\\Java\\jdk1.8.0_241")
Sys.getenv("JAVA_HOME")

#load required packages
library("RODBC")
library("CrossVA")
library("rJava")
library("openVA")
library('nbc4va')
library('plyr')
library('stringr')
library('stringi')

vadata = read.csv("vaclean.csv", stringsAsFactors = F)
#View(head(vadata))
colnames(vadata) = tolower(names(vadata))

#remove blank VAs
#vadatacl= vadata[which(vadata$id10013=='yes'),]
#vadatacl[is.na(vadatacl)]='.'
#num_nova= dim(vadata)[1] - dim(vadatacl)[1]

#vadatacl$ageindays2[!which(is.na(vadatacl$ageindays2))]
#vadatacl$bid2[!which(is.na(vadatacl$bid2))]

Converter = function (odk) 
{
  odkNames <- tolower(names(odk))
  whoNamesNum <- c("Id10106","Id10108","Id10351","Id10148",
                   "Id10154","Id10161","Id10162","Id10163","Id10167","Id10169",
                   "Id10176","Id10178","Id10179","Id10179_1","Id10182","Id10183","Id10184_a",
                   "Id10184_b","Id10184_c","Id10190_a","Id10190_b","Id10196","Id10197",
                   "Id10198","Id10201","Id10202","Id10205","Id10206","Id10209","Id10211",
                   "Id10213","Id10216","Id10221","Id10232","Id10234","Id10248",
                   "Id10250","Id10262","Id10266","Id10274","Id10285","Id10303","Id10309",
                   "Id10319","Id10332","Id10352","Id10358","Id10359","Id10359_a","Id10367",
                   "Id10394","Id10379","Id10380","Id10382","Id10392","Id10415","Id10416")
  whoNamesNum <- tolower(whoNamesNum)
  odk[,whoNamesNum][odk[,whoNamesNum]=='99'] = '.'
  odk[,whoNamesNum][odk[,whoNamesNum]=='88'] = '.'
  odk[,whoNamesNum][odk[,whoNamesNum]=='999'] = '.'
  
  whoNames <- c("Id10004", "Id10004", "Id10019", "Id10019", 
                "Id10022", "Id10022", "Id10022", "Id10022", "Id10022", 
                "Id10022", "Id10022", "Id10022", "Id10022", "Id10022", 
                "Id10022", "Id10022", "Id10022", "Id10022", "Id10059", 
                "Id10077", "Id10079", "Id10082", "Id10083", "Id10084", 
                "Id10085", "Id10086", "Id10087", "Id10089", "Id10090", 
                "Id10091", "Id10092", "Id10093", "Id10094", "Id10095", 
                "Id10096", "Id10098", "Id10099", "Id10100", "Id10104", 
                "Id10105", "Id10106", "Id10107", "Id10108", "Id10109", 
                "Id10110", "Id10111", "Id10112", "Id10113", "Id10114", 
                "Id10115", "Id10116", "Id10120", "Id10120", "Id10123", 
                "Id10125", "Id10127", "Id10128", "Id10129", "Id10130", 
                "Id10131", "Id10132", "Id10133", "Id10134", "Id10135", 
                "Id10136", "Id10137", "Id10138", "Id10139", "Id10140", 
                "Id10141", "Id10142", "Id10143", "Id10144", "Id10147", 
                "Id10148", "Id10148", "Id10148", "Id10149", "Id10150", 
                "Id10151", "Id10152", "Id10153", "Id10154", "Id10154", 
                "Id10155", "Id10156", "Id10157", "Id10158", "Id10159", 
                "Id10161", "Id10165", "Id10166", "Id10167", "Id10167", 
                "Id10168", "Id10169", "Id10169", "Id10170", "Id10171", 
                "Id10172", "Id10173", "Id10174", "Id10175", "Id10176", 
                "Id10178", "Id10181", "Id10182", "Id10182", "Id10182", 
                "Id10183", "Id10184_units", "Id10185", "Id10186", "Id10187", 
                "Id10188", "Id10189", "Id10190_units", "Id10191", "Id10192", 
                "Id10193", "Id10194", "Id10195", "Id10197", "Id10197", 
                "Id10199", "Id10199", "Id10200", "Id10201", "Id10201", 
                "Id10203", "Id10204", "Id10205", "Id10205", "Id10207", 
                "Id10208", "Id10209", "Id10209", "Id10210", "Id10211", 
                "Id10212", "Id10213", "Id10214", "Id10215", "Id10216", 
                "Id10217", "Id10218", "Id10219", "Id10220", "Id10221", 
                "Id10221", "Id10222", "Id10223", "Id10224", "Id10225", 
                "Id10226", "Id10227", "Id10228", "Id10229", "Id10230", 
                "Id10231", "Id10232", "Id10233", "Id10234", "Id10234", 
                "Id10235", "Id10235", "Id10235", "Id10235", "Id10236", 
                "Id10237", "Id10238", "Id10239", "Id10240", "Id10241", 
                "Id10242", "Id10243", "Id10244", "Id10245", "Id10246", 
                "Id10247", "Id10248", "Id10249", "Id10250", "Id10251", 
                "Id10252", "Id10253", "Id10254", "Id10255", "Id10256", 
                "Id10257", "Id10258", "Id10259", "Id10260", "Id10260", 
                "Id10260", "Id10260", "Id10260", "Id10260", "Id10260", 
                "Id10261", "Id10262", "Id10263", "Id10263", "Id10264", 
                "Id10265", "Id10266", "Id10267", "Id10268", "Id10269", 
                "Id10270", "Id10271", "Id10272", "Id10273", "Id10274", 
                "Id10275", "Id10276", "Id10277", "Id10278", "Id10279", 
                "Id10281", "Id10282", "Id10283", "Id10284", "Id10285", 
                "Id10286", "Id10287", "Id10288", "Id10289", "Id10290", 
                "Id10294", "Id10295", "Id10296", "Id10297", "Id10298", 
                "Id10299", "Id10300", "Id10301", "Id10302", "Id10303", 
                "Id10304", "Id10305", "Id10306", "Id10309", "Id10310", 
                "Id10312", "Id10313", "Id10314", "Id10315", "Id10316", 
                "Id10317", "Id10318", "Id10319", "Id10319", "Id10320", 
                "Id10321", "Id10322", "Id10323", "Id10324", "Id10325", 
                "Id10326", "Id10327", "Id10328", "Id10329", "Id10330", 
                "Id10331", "Id10332", "Id10333", "Id10334", "Id10335", 
                "Id10336", "Id10337", "Id10337", "Id10337", "Id10338", 
                "Id10340", "Id10342", "Id10343", "Id10344", "Id10347", 
                "Id10354", "Id10355", "Id10356", "Id10357", "Id10358", 
                "Id10360", "Id10360", "Id10360", "Id10361", "Id10362", 
                "Id10363", "Id10364", "Id10365", "Id10367", "Id10367", 
                "Id10367", "Id10368", "Id10369", "Id10370", "Id10371", 
                "Id10372", "Id10373", "Id10376", "Id10377", "Id10382", 
                "Id10383", "Id10384", "Id10385", "Id10387", "Id10388", 
                "Id10389", "Id10391", "Id10393", "Id10394", "Id10394", 
                "Id10395", "Id10396", "Id10397", "Id10398", "Id10399", 
                "Id10400", "Id10401", "Id10402", "Id10403", "Id10404", 
                "Id10405", "Id10406", "Id10408", "Id10411", "Id10412", 
                "Id10413", "Id10414", "Id10415", "Id10418", "Id10419", 
                "Id10420", "Id10421", "Id10422", "Id10423", "Id10424", 
                "Id10425", "Id10426", "Id10427", "Id10428", "Id10450", 
                "Id10451", "Id10452", "Id10453", "Id10454", "Id10455", 
                "Id10456", "Id10457", "Id10458", "Id10459")
  whoNames <- tolower(whoNames)
  
  
  iv5Names <- c("i004a", "i004b", "i019a", "i019b", "i022a", 
                "i022b", "i022c", "i022d", "i022e", "i022f", "i022g", 
                "i022h", "i022i", "i022j", "i022k", "i022l", "i022m", 
                "i022n", "i059o", "i077o", "i079o", "i082o", "i083o", 
                "i084o", "i085o", "i086o", "i087o", "i089o", "i090o", 
                "i091o", "i092o", "i093o", "i094o", "i095o", "i096o", 
                "i098o", "i099o", "i100o", "i104o", "i105o", "i106a", 
                "i107o", "i108a", "i109o", "i110o", "i111o", "i112o", 
                "i113o", "i114o", "i115o", "i116o", "i120a", "i120b", 
                "i123o", "i125o", "i127o", "i128o", "i129o", "i130o", 
                "i131o", "i132o", "i133o", "i134o", "i135o", "i136o", 
                "i137o", "i138o", "i139o", "i140o", "i141o", "i142o", 
                "i143o", "i144o", "i147o", "i148a", "i148b", "i148c", 
                "i149o", "i150a", "i151a", "i152o", "i153o", "i154a", 
                "i154b", "i155o", "i156o", "i157o", "i158o", "i159o", 
                "i161a", "i165a", "i166o", "i167a", "i167b", "i168o", 
                "i169a", "i169b", "i170o", "i171o", "i172o", "i173a", 
                "i174o", "i175o", "i176a", "i178a", "i181o", "i182a", 
                "i182b", "i182c", "i183a", "i184a", "i185o", "i186o", 
                "i187o", "i188o", "i189o", "i190o", "i191o", "i192o", 
                "i193o", "i194o", "i195o", "i197a", "i197b", "i199a", 
                "i199b", "i200o", "i201a", "i201b", "i203a", "i204o", 
                "i205a", "i205b", "i207o", "i208o", "i209a", "i209b", 
                "i210o", "i211a", "i212o", "i213o", "i214o", "i215o", 
                "i216a", "i217o", "i218o", "i219o", "i220o", "i221a", 
                "i221b", "i222o", "i223o", "i224o", "i225o", "i226o", 
                "i227o", "i228o", "i229o", "i230o", "i231o", "i232a", 
                "i233o", "i234a", "i234b", "i235a", "i235b", "i235c", 
                "i235d", "i236o", "i237o", "i238o", "i239o", "i240o", 
                "i241o", "i242o", "i243o", "i244o", "i245o", "i246o", 
                "i247o", "i248a", "i249o", "i250a", "i251o", "i252o", 
                "i253o", "i254o", "i255o", "i256o", "i257o", "i258o", 
                "i259o", "i260a", "i260b", "i260c", "i260d", "i260e", 
                "i260f", "i260g", "i261o", "i262a", "i263a", "i263b", 
                "i264o", "i265o", "i266a", "i267o", "i268o", "i269o", 
                "i270o", "i271o", "i272o", "i273o", "i274a", "i275o", 
                "i276o", "i277o", "i278o", "i279o", "i281o", "i282o", 
                "i283o", "i284o", "i285a", "i286o", "i287o", "i288o", 
                "i289o", "i290o", "i294o", "i295o", "i296o", "i297o", 
                "i298o", "i299o", "i300o", "i301o", "i302o", "i303a", 
                "i304o", "i305o", "i306o", "i309o", "i310o", "i312o", 
                "i313o", "i314o", "i315o", "i316o", "i317o", "i318o", 
                "i319a", "i319b", "i320o", "i321o", "i322o", "i323o", 
                "i324o", "i325o", "i326o", "i327o", "i328o", "i329o", 
                "i330o", "i331o", "i332a", "i333o", "i334o", "i335o", 
                "i336o", "i337a", "i337b", "i337c", "i338o", "i340o", 
                "i342o", "i343o", "i344o", "i347o", "i354o", "i355a", 
                "i356o", "i357o", "i358a", "i360a", "i360b", "i360c", 
                "i361o", "i362o", "i363o", "i364o", "i365o", "i367a", 
                "i367b", "i367c", "i368o", "i369o", "i370o", "i371o", 
                "i372o", "i373o", "i376o", "i377o", "i382a", "i383o", 
                "i384o", "i385a", "i387o", "i388o", "i389o", "i391o", 
                "i393o", "i394a", "i394b", "i395o", "i396o", "i397o", 
                "i398o", "i399o", "i400o", "i401o", "i402o", "i403o", 
                "i404o", "i405o", "i406o", "i408o", "i411o", "i412o", 
                "i413o", "i414a", "i415a", "i418o", "i419o", "i420o", 
                "i421o", "i422o", "i423o", "i424o", "i425o", "i426o", 
                "i427o", "i428o", "i450o", "i451o", "i452o", "i453o", 
                "i454o", "i455o", "i456o", "i457o", "i458o", "i459o")
  iv5Out <- matrix(".", nrow = nrow(odk), ncol = 353)
  tmpMat <- matrix(sapply(whoNames, stri_endswith_fixed, str = odkNames), 
                   nrow = length(odkNames))
  indexData <- apply(tmpMat, 2, which)
  warnZeroMatch <- which(sapply(indexData, length) == 0)
  if (length(warnZeroMatch) > 0) {
    cat(paste("Expecting indicator(s) with name(s): ", whoNames[warnZeroMatch], 
              sep = ""), sep = "\n")
    stop("Problem with data: please add above columns to your data frame")
  }
  qYesNo <- c(20:40, 42, 44:51, 54:74, 78, 81:82, 85:89, 92, 
              95, 98:100, 102:103, 106, 112:116, 118:122, 127, 131, 
              134:135, 138, 140, 142:143, 145:148, 151:160, 162, 169:180, 
              182, 184:192, 200, 204:205, 207:213, 215:223, 225:238, 
              240:242, 244:251, 254:265, 267:270, 274:280, 282, 288:292, 
              296:303, 305:306, 308:312, 315:330, 333:353)
  tmpMat <- matrix(sapply(whoNames[qYesNo], stri_endswith_fixed, 
                          str = odkNames), nrow = length(odkNames))
  indexData <- apply(tmpMat, 2, which)
  iv5Out[, qYesNo] <- as.matrix(odk[, indexData])
  iv5Out[iv5Out == "yes"] <- "y"
  iv5Out[iv5Out == "no"] <- "n"
  iv5Out[iv5Out == "dk"] <- "."
  iv5Out[iv5Out == "ref"] <- "."
  iv5Out[iv5Out == ""] <- "."
  iv5Out[is.na(iv5Out)] <- "."
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[1]))
  iv5Out[tolower(odk[, indexData]) == "wet" | tolower(odk[, 
                                                          indexData]) == "wet season", 1] <- "y"
  iv5Out[tolower(odk[, indexData]) == "dry" | tolower(odk[, 
                                                          indexData]) == "dry season", 1] <- "n"
  iv5Out[tolower(odk[, indexData]) == "wet" | tolower(odk[, 
                                                          indexData]) == "wet season", 2] <- "n"
  iv5Out[tolower(odk[, indexData]) == "dry" | tolower(odk[, 
                                                          indexData]) == "dry season", 2] <- "y"
  indexData_sex <- which(stri_endswith_fixed(odkNames, whoNames[3]))
  iv5Out[tolower(odk[, indexData_sex]) == "male", 3] <- "y"
  iv5Out[tolower(odk[, indexData_sex]) == "female", 3] <- "n"
  iv5Out[tolower(odk[, indexData_sex]) == "male", 4] <- "n"
  iv5Out[tolower(odk[, indexData_sex]) == "female", 4] <- "y"
  indexData1y <- which(stri_endswith_fixed(odkNames, "ageinyears2"))
  indexData1m <- which(stri_endswith_fixed(odkNames, "ageinmonths"))
  indexData1d <- which(stri_endswith_fixed(odkNames, "ageindays"))
  indexData2 <- which(stri_endswith_fixed(odkNames, "age_group"))
  indexData3 <- which(stri_endswith_fixed(odkNames, "age_adult"))
  indexData4 <- which(stri_endswith_fixed(odkNames, "age_child_unit"))
  indexData4d <- which(stri_endswith_fixed(odkNames, "age_child_days"))
  indexData4m <- which(stri_endswith_fixed(odkNames, "age_child_months"))
  indexData4y <- which(stri_endswith_fixed(odkNames, "age_child_years"))
  indexData5d <- which(stri_endswith_fixed(odkNames, "age_neonate_days"))
  indexData_isNeonatal <- which(stri_endswith_fixed(odkNames, 
                                                    "isneonatal"))
  indexData_isChild <- which(stri_endswith_fixed(odkNames, 
                                                 "ischild"))
  indexData_isAdult <- which(stri_endswith_fixed(odkNames, 
                                                 "isadult"))
  iv5Out[odk[, indexData1y] >= 65, 5] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "adult" & odk[, indexData3] >= 65, 5] <- "y"
  checkNumeric <- tryCatch(as.numeric(odk[, indexData1y]), 
                           warning = function(w) return(-9999))
  if (sum(checkNumeric, na.rm = TRUE) < 0) 
    iv5Out[, 5] <- NA
  iv5Out[odk[, indexData1y] < 65 & odk[, indexData1y] >= 50, 
         6] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "adult" & odk[, indexData3] < 65 & odk[, indexData3] >= 
           50, 6] <- "y"
  iv5Out[odk[, indexData1y] < 50 & odk[, indexData1y] >= 12, 
         7] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "adult" & odk[, indexData3] < 50 & odk[, indexData3] >= 
           12, 7] <- "y"
  iv5Out[odk[, indexData1y] < 12 & odk[, indexData1y] >= 5, 
         8] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "adult" & odk[, indexData3] < 12 & odk[, indexData3] >= 
           5, 8] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "days" & odk[, indexData4d] < 
           12 * 365.25 & odk[, indexData4d] >= 5 * 365.25, 8] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "months" & odk[, indexData4m] < 
           12 * 12 & odk[, indexData4m] >= 5 * 12, 8] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "years" & odk[, indexData4y] < 
           12 & odk[, indexData4y] >= 5, 8] <- "y"
  iv5Out[odk[, indexData1y] < 5 & odk[, indexData1y] >= 1, 
         9] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "days" & odk[, indexData4d] < 
           5 * 365.25 & odk[, indexData4d] >= 1 * 365.25, 9] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "months" & odk[, indexData4m] < 
           5 * 12 & odk[, indexData4m] >= 1 * 12, 9] <- "y"
  iv5Out[is.na(odk[, indexData1y]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "years" & odk[, indexData4y] < 
           5 & odk[, indexData4y] >= 1, 9] <- "y"
  iv5Out[odk[, indexData1d] < 365.25 & odk[, indexData1d] >= 
           28, 10] <- "y"
  iv5Out[is.na(odk[, indexData1d]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "days" & odk[, indexData4d] < 
           365.25 & odk[, indexData4d] >= 28, 10] <- "y"
  iv5Out[is.na(odk[, indexData1m]) & odk[, indexData2] == 
           "child" & odk[, indexData4] == "months" & odk[, indexData4m] < 
           12 & odk[, indexData4m] >= 1, 10] <- "y"
  iv5Out[odk[, indexData1d] < 28, 11] <- "y"
  iv5Out[is.na(odk[, indexData1d]) & odk[, indexData2] == 
           "neonate", 11] <- "y"
  iv5Out[odk[, indexData1d] < 1, 12] <- "y"
  ageNeonate <- odk[, indexData5d]
  iv5Out[odk[, indexData2] == "neonate" & !is.na(odk[, indexData5d]) & 
           ageNeonate < 1, 12] <- "y"
  iv5Out[odk[, indexData1d] >= 1 & odk[, indexData1d] <= 2, 
         13] <- "y"
  iv5Out[odk[, indexData2] == "neonate" & !is.na(odk[, indexData5d]) & 
           ageNeonate < 2 & ageNeonate >= 1, 13] <- "y"
  iv5Out[odk[, indexData1d] > 2 & odk[, indexData1d] < 7, 
         13] <- "y"
  iv5Out[odk[, indexData2] == "neonate" & !is.na(odk[, indexData5d]) & 
           ageNeonate < 7 & ageNeonate >= 2, 14] <- "y"
  iv5Out[odk[, indexData1d] >= 7 & odk[, indexData1d] < 28, 
         13] <- "y"
  iv5Out[odk[, indexData2] == "neonate" & !is.na(odk[, indexData5d]) & 
           ageNeonate < 28 & ageNeonate >= 7, 15] <- "y"
  indexData6 <- iv5Out[, 5:15] != "y"
  indexData7 <- rowSums(iv5Out[, 5:15] == "y", na.rm = TRUE)
  iv5Out[indexData7 == 1, 5:15][indexData6[indexData7 == 1, 
                                           ]] <- "n"
  iv5Out[, 16] <- ifelse(odk[, indexData_sex] == "female" & 
                           odk[, indexData1y] < 20 & odk[, indexData1y] >= 12, 
                         "y", ".")
  iv5Out[odk[, indexData_sex] == "female" & is.na(odk[, indexData1y]) & 
           odk[, indexData2] == "adult" & odk[, indexData3] < 20 & 
           odk[, indexData3] >= 12, 16] <- "y"
  iv5Out[odk[, indexData_isNeonatal] == 1, 16] <- "n"
  iv5Out[odk[, indexData_isChild] == 1, 16] <- "n"
  iv5Out[odk[, indexData_sex] == "male", 16] <- "n"
  iv5Out[odk[, indexData1y] < 12, 16] <- "n"
  iv5Out[odk[, indexData1y] > 19, 16] <- "n"
  iv5Out[, 17] <- ifelse(odk[, indexData_sex] == "female" & 
                           odk[, indexData1y] < 35 & odk[, indexData1y] >= 20, 
                         "y", ".")
  iv5Out[odk[, indexData_sex] == "female" & is.na(odk[, indexData1y]) & 
           odk[, indexData2] == "adult" & odk[, indexData3] < 35 & 
           odk[, indexData3] >= 20, 17] <- "y"
  iv5Out[odk[, indexData_isNeonatal] == 1, 17] <- "n"
  iv5Out[odk[, indexData_isChild] == 1, 17] <- "n"
  iv5Out[odk[, indexData_sex] == "male", 17] <- "n"
  iv5Out[odk[, indexData1y] < 20, 17] <- "n"
  iv5Out[odk[, indexData1y] > 34, 17] <- "n"
  iv5Out[, 18] <- ifelse(odk[, indexData_sex] == "female" & 
                           odk[, indexData1y] < 50 & odk[, indexData1y] >= 35, 
                         "y", ".")
  iv5Out[odk[, indexData_sex] == "female" & is.na(odk[, indexData1y]) & 
           odk[, indexData2] == "adult" & odk[, indexData3] < 50 & 
           odk[, indexData3] >= 35, 18] <- "y"
  iv5Out[odk[, indexData_isNeonatal] == 1, 18] <- "n"
  iv5Out[odk[, indexData_isChild] == 1, 18] <- "n"
  iv5Out[odk[, indexData_sex] == "male", 18] <- "n"
  iv5Out[odk[, indexData1y] < 35, 18] <- "n"
  iv5Out[odk[, indexData1y] > 49, 18] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[19]))
  iv5Out[odk[, indexData_sex] == "female" & tolower(odk[, 
                                                        indexData]) == "married", 19] <- "y"
  iv5Out[odk[, indexData_sex] == "female" & tolower(odk[, 
                                                        indexData]) == "single", 19] <- "n"
  iv5Out[odk[, indexData_sex] == "female" & tolower(odk[, 
                                                        indexData]) == "partner", 19] <- "n"
  iv5Out[odk[, indexData_sex] == "female" & tolower(odk[, 
                                                        indexData]) == "divorced", 19] <- "n"
  iv5Out[odk[, indexData_sex] == "female" & tolower(odk[, 
                                                        indexData]) == "widowed", 19] <- "n"
  iv5Out[odk[, indexData_sex] == "male", 19] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[41]))
  iv5Out[odk[, indexData] > 5 , 41] <- "y"
  iv5Out[odk[, indexData] <= 5, 41] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[43]))
  iv5Out[odk[, indexData] > 24, 43] <- "y"
  iv5Out[odk[, indexData] <= 24, 43] <- "n"
  indexDatad <- which(stri_endswith_fixed(odkNames, "id10120"))
  iv5Out[odk[, indexDatad] < 21, 52] <- "y"
  iv5Out[odk[, indexDatad] >= 21, 52] <- "n"
  iv5Out[odk[, indexDatad] >= 21, 53] <- "y"
  iv5Out[odk[, indexDatad] < 21, 53] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[75]))
  iv5Out[odk[, indexData] < 7, 75] <- "y"
  iv5Out[odk[, indexData] >= 7, 75] <- "n"
  iv5Out[odk[, indexData] >= 7 & odk[, indexData] < 14, 76] <- "y"
  iv5Out[odk[, indexData] < 7, 76] <- "n"
  iv5Out[odk[, indexData] >= 14, 77] <- "y"
  iv5Out[odk[, indexData] < 14, 77] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[79]))
  iv5Out[tolower(odk[, indexData]) == "severe", 79] <- "y"
  iv5Out[tolower(odk[, indexData]) == "mild", 79] <- "n"
  iv5Out[tolower(odk[, indexData]) == "moderate", 79] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[80]))
  iv5Out[tolower(odk[, indexData]) == "continuous", 80] <- "y"
  iv5Out[tolower(odk[, indexData]) == "nightly", 80] <- "n"
  iv5Out[tolower(odk[, indexData]) == "on_and_off", 80] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[83]))
  iv5Out[odk[, indexData[1]] < 21, 83] <- "y"
  iv5Out[odk[, indexData[1]] >= 21, 83] <- "n"
  iv5Out[odk[, indexData[1]] >= 21, 84] <- "y"
  iv5Out[odk[, indexData[1]] < 21, 84] <- "n"
  indexDatad <- which(stri_endswith_fixed(odkNames, whoNames[90]))
  indexDatam <- which(stri_endswith_fixed(odkNames, "id10162"))
  indexDatay <- which(stri_endswith_fixed(odkNames, "id10163"))
  iv5Out[odk[, indexDatad] >= 3, 90] <- "y"
  iv5Out[odk[, indexDatad] < 3, 90] <- "n"
  iv5Out[odk[, indexDatam] >= 1, 90] <- "y"
  iv5Out[odk[, indexDatay] >= 1, 90] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[91]))
  iv5Out[tolower(odk[, indexData]) == "continuous", 91] <- "y"
  iv5Out[tolower(odk[, indexData]) == "on_and_off", 91] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[93]))
  iv5Out[odk[, indexData[1]] < 14, 93] <- "y"
  iv5Out[odk[, indexData[1]] >= 14, 93] <- "n"
  iv5Out[odk[, indexData[1]] >= 14, 94] <- "y"
  iv5Out[odk[, indexData[1]] < 14, 94] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[96]))
  iv5Out[odk[, indexData[1]] < 14, 96] <- "y"
  iv5Out[odk[, indexData[1]] >= 14, 96] <- "n"
  iv5Out[odk[, indexData[1]] >= 14, 97] <- "y"
  iv5Out[odk[, indexData[1]] < 14, 97] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[101]))
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "grunting"), 
         101] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "stridor"), 
         101] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "wheezing"), 
         101] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "no"), 
         101] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[104]))
  iv5Out[odk[, indexData] >= 3, 104] <- "y"
  iv5Out[odk[, indexData] < 3, 104] <- "n"
  indexData_unit <- which(stri_endswith_fixed(odkNames, "id10178_unit"))
  indexDatam <- which(stri_endswith_fixed(odkNames, "id10178"))
  indexDatah <- which(stri_endswith_fixed(odkNames, "id10179"))
  indexDatad <- which(stri_endswith_fixed(odkNames, "id10179_1"))
  iv5Out[tolower(odk[, indexData_unit]) == "minutes" & odk[, 
                                                           indexDatam] >= 30, 105] <- "y"
  iv5Out[tolower(odk[, indexData_unit]) == "hours" & odk[, 
                                                         indexDatah] >= 0.5, 105] <- "y"
  iv5Out[tolower(odk[, indexData_unit]) == "days" & odk[, 
                                                        indexDatad] >= 1, 105] <- "y"
  iv5Out[tolower(odk[, indexData_unit]) == "minutes" & odk[, 
                                                           indexDatam] < 30, 105] <- "n"
  iv5Out[tolower(odk[, indexData_unit]) == "hours" & odk[, 
                                                         indexDatah] < 0.5, 105] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[107]))
  iv5Out[odk[, indexData] < 14, 107] <- "y"
  iv5Out[odk[, indexData] >= 14, 107] <- "n"
  iv5Out[odk[, indexData] < 28 & odk[, indexData] >= 14, 108] <- "y"
  iv5Out[odk[, indexData] < 14, 108] <- "n"
  iv5Out[odk[, indexData] >= 28, 108] <- "n"
  iv5Out[odk[, indexData] >= 28, 109] <- "y"
  iv5Out[odk[, indexData] < 28, 109] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[110]))
  iv5Out[odk[, indexData] >= 4 & odk[, indexData] < 999, 110] <- "y"
  iv5Out[odk[, indexData] < 4, 110] <- "n"
  indexData181 <- which(stri_endswith_fixed(odkNames, "id10181"))
  indexDataIsNeonatal <- which(stri_endswith_fixed(odkNames, 
                                                   "isneonatal"))
  indexDataIsChild <- which(stri_endswith_fixed(odkNames, 
                                                "ischild"))
  indexData184_a <- which(stri_endswith_fixed(odkNames, "id10184_a"))
  indexData184_units <- which(stri_endswith_fixed(odkNames, 
                                                  "id10184_units"))
  indexData184_b <- which(stri_endswith_fixed(odkNames, "id10184_b"))
  indexData184_c <- which(stri_endswith_fixed(odkNames, "id10184_c"))
  iv5Out[odk[, indexData184_a] >= 3 & tolower(odk[, indexData181]) == 
           "yes" & tolower(odk[, indexDataIsNeonatal]) == "yes", 
         111] <- "y"
  iv5Out[odk[, indexData184_a] < 3 & tolower(odk[, indexData181]) == 
           "yes" & tolower(odk[, indexDataIsNeonatal]) == "yes", 
         111] <- "n"
  iv5Out[odk[, indexData184_b] >= 3 & tolower(odk[, indexData184_units]) == 
           "days", 111] <- "y"
  iv5Out[odk[, indexData184_b] < 3 & tolower(odk[, indexData184_units]) == 
           "days", 111] <- "n"
  iv5Out[odk[, indexData184_c] >= 1 & tolower(odk[, indexData184_units]) == 
           "months", 111] <- "y"
  indexData190_units <- which(stri_endswith_fixed(odkNames, 
                                                  "id10190_units"))
  indexData190_a <- which(stri_endswith_fixed(odkNames, "id10190_a"))
  indexData190_b <- which(stri_endswith_fixed(odkNames, "id10190_b"))
  iv5Out[odk[, indexData190_a] >= 3 & tolower(odk[, indexData190_units]) == 
           "days", 117] <- "y"
  iv5Out[odk[, indexData190_a] < 3 & tolower(odk[, indexData190_units]) == 
           "days", 117] <- "n"
  iv5Out[odk[, indexData190_b] >= 1 & tolower(odk[, indexData190_units]) == 
           "months", 117] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[122]))
  indexDatad <- which(stri_endswith_fixed(odkNames, "id10197_a"))
  indexDatah <- which(stri_endswith_fixed(odkNames, "id10196"))
  indexDatam <- which(stri_endswith_fixed(odkNames, "id10198"))
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14, 123] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14, 123] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatah] < 
           (24 * 14), 123] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatah] >= 
           (24 * 14), 123] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatam] < 
           1, 123] <- "y"
  iv5Out[tolower(odk[, indexData]) == "no", 123] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14, 124] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14, 124] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatah] >= 
           (24 * 14), 124] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatah] < 
           (24 * 14), 124] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatam] >= 
           1, 124] <- "y"
  iv5Out[tolower(odk[, indexData]) == "no", 124] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[125]))
  iv5Out[tolower(odk[, indexData]) == "upper_abdomen", 125] <- "y"
  iv5Out[tolower(odk[, indexData]) == "upper_lower_abdomen", 
         125] <- "y"
  iv5Out[tolower(odk[, indexData]) == "lower_abdomen", 125] <- "n"
  iv5Out[tolower(odk[, indexData]) == "upper_abdomen", 126] <- "n"
  iv5Out[tolower(odk[, indexData]) == "upper_lower_abdomen", 
         126] <- "y"
  iv5Out[tolower(odk[, indexData]) == "lower_abdomen", 126] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, "id10200"))
  indexDatad <- which(stri_endswith_fixed(odkNames, whoNames[128]))
  indexDatam <- which(stri_endswith_fixed(odkNames, "id10202"))
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & odk[, indexDatam] == 0, 128] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & is.na(odk[, indexDatam]), 128] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & odk[, indexDatam] == 0, 128] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & is.na(odk[, indexDatam]), 128] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatam] >= 
           1, 128] <- "n"
  iv5Out[tolower(odk[, indexData]) == "no", 128] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatam] >= 
           1, 129] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & odk[, indexDatam] == 0, 129] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & is.na(odk[, indexDatam]), 129] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & odk[, indexDatam] == 0, 129] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & is.na(odk[, indexDatam]), 129] <- "n"
  iv5Out[tolower(odk[, indexData]) == "no", 129] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[130]))
  iv5Out[tolower(odk[, indexData]) == "rapidly", 130] <- "y"
  iv5Out[tolower(odk[, indexData]) == "slowly", 130] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, "id10204"))
  indexDatad <- which(stri_endswith_fixed(odkNames, whoNames[132]))
  indexDatam <- which(stri_endswith_fixed(odkNames, "id10206"))
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & odk[, indexDatam] == 0, 132] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & is.na(odk[, indexDatam]), 132] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & odk[, indexDatam] == 0, 132] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & is.na(odk[, indexDatam]), 132] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatam] >= 
           1, 132] <- "n"
  iv5Out[tolower(odk[, indexData]) == "no", 132] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & odk[, indexDatam] == 0, 133] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           14 & is.na(odk[, indexDatam]), 133] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & odk[, indexDatam] == 0, 133] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           14 & is.na(odk[, indexDatam]), 133] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatam] >= 
           1, 133] <- "y"
  iv5Out[tolower(odk[, indexData]) == "no", 133] <- "n"
  #missing whoNames[135] /id10208
  #missing indexData <- which(stri_endswith_fixed(odkNames, "id10208"))
  indexDatad <- which(stri_endswith_fixed(odkNames, whoNames[136]))
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           7, 136] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           7, 136] <- "n"
  iv5Out[tolower(odk[, indexData]) == "no", 136] <- "n"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           7, 137] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           7, 137] <- "n"
  iv5Out[tolower(odk[, indexData]) == "no", 137] <- "n"
  indexDatad <- which(stri_endswith_fixed(odkNames, whoNames[139]))
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] >= 
           7, 139] <- "y"
  iv5Out[tolower(odk[, indexData]) == "yes" & odk[, indexDatad] < 
           7, 139] <- "n"
  iv5Out[tolower(odk[, indexData]) == "no", 139] <- "n"
  indexDatad <- which(stri_endswith_fixed(odkNames, whoNames[141]))
  iv5Out[odk[, indexDatad] >= 3, 141] <- "y"
  iv5Out[odk[, indexDatad] < 3, 141] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[144]))
  iv5Out[odk[, indexData] >= 6, 144] <- "y"
  iv5Out[odk[, indexData] < 6, 144] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[149]))
  iv5Out[odk[, indexData] < 10, 149] <- "y"
  iv5Out[odk[, indexData] >= 10, 149] <- "n"
  iv5Out[odk[, indexData] < 10, 150] <- "n"
  iv5Out[odk[, indexData] >= 10, 150] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[161]))
  iv5Out[odk[, indexData] >= 14, 161] <- "y"
  iv5Out[odk[, indexData] < 14, 161] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[163]))
  iv5Out[odk[, indexData] < 7, 163] <- "y"
  iv5Out[odk[, indexData] >= 7, 163] <- "n"
  iv5Out[odk[, indexData] >= 7, 164] <- "y"
  iv5Out[odk[, indexData] < 7, 164] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[165]))
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "face"), 
         165] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), negate = TRUE, 
                             "face"), 165] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 165] <- "."
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[166]))
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "abdomen|trunk"), 
         166] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), negate = TRUE, 
                             "abdomen|trunk"), 166] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 166] <- "."
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[167]))
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "extremities"), 
         167] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), negate = TRUE, 
                             "extremities"), 167] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 167] <- "."
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[168]))
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), "everywhere"), 
         168] <- "y"
  iv5Out[stri_endswith_fixed(tolower(odk[, indexData]), negate = TRUE, 
                             "everywhere"), 168] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 168] <- "."
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[181]))
  iv5Out[odk[, indexData] >= 7, 181] <- "y"
  iv5Out[odk[, indexData] < 7, 181] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[183]))
  iv5Out[odk[, indexData] >= 3, 183] <- "y"
  iv5Out[odk[, indexData] < 3, 183] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[193]))
  iv5Out[tolower(odk[, indexData]) == "right_side", 193] <- "y"
  iv5Out[tolower(odk[, indexData]) != "right_side", 193] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 193] <- "."
  iv5Out[tolower(odk[, indexData]) == "left_side", 194] <- "y"
  iv5Out[tolower(odk[, indexData]) != "left_side", 194] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 194] <- "."
  iv5Out[tolower(odk[, indexData]) == "lower_part_of_body", 
         195] <- "y"
  iv5Out[tolower(odk[, indexData]) != "lower_part_of_body", 
         195] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 195] <- "."
  iv5Out[tolower(odk[, indexData]) == "upper_part_of_body", 
         196] <- "y"
  iv5Out[tolower(odk[, indexData]) != "upper_part_of_body", 
         196] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 196] <- "."
  iv5Out[tolower(odk[, indexData]) == "one_leg_only", 197] <- "y"
  iv5Out[tolower(odk[, indexData]) != "one_leg_only", 197] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 197] <- "."
  iv5Out[tolower(odk[, indexData]) == "one_arm_only", 198] <- "y"
  iv5Out[tolower(odk[, indexData]) != "one_arm_only", 198] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 198] <- "."
  iv5Out[tolower(odk[, indexData]) == "whole_body", 199] <- "y"
  iv5Out[tolower(odk[, indexData]) != "whole_body", 199] <- "n"
  iv5Out[tolower(odk[, indexData]) == "", 199] <- "."
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[201]))
  iv5Out[odk[, indexData] >= 7, 201] <- "y"
  iv5Out[odk[, indexData] < 7, 201] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[202]))
  iv5Out[tolower(odk[, indexData]) == "solids", 202] <- "y"
  iv5Out[tolower(odk[, indexData]) == "both", 202] <- "y"
  iv5Out[tolower(odk[, indexData]) == "liquids", 202] <- "n"
  iv5Out[tolower(odk[, indexData]) == "solids", 203] <- "n"
  iv5Out[tolower(odk[, indexData]) == "both", 203] <- "y"
  iv5Out[tolower(odk[, indexData]) == "liquids", 203] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[206]))
  iv5Out[odk[, indexData] >= 21, 206] <- "y"
  iv5Out[odk[, indexData] < 21, 206] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[214]))
  iv5Out[odk[, indexData[1]] >= 2, 214] <- "y"
  iv5Out[odk[, indexData[1]] < 2, 214] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[224]))
  iv5Out[odk[, indexData] > 3, 224] <- "y"
  iv5Out[odk[, indexData] <= 3, 224] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[239]))
  iv5Out[odk[, indexData] >= 4, 239] <- "y"
  iv5Out[odk[, indexData] < 4, 239] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[243]))
  iv5Out[odk[, indexData] < 6, 243] <- "y"
  iv5Out[odk[, indexData] >= 6, 243] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[252]))
  iv5Out[odk[, indexData] == 0, 252] <- "y"
  iv5Out[odk[, indexData] > 0, 252] <- "n"
  iv5Out[odk[, indexData] >= 4, 253] <- "y"
  iv5Out[odk[, indexData] < 4, 253] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[266]))
  iv5Out[odk[, indexData] > 24, 266] <- "y"
  iv5Out[odk[, indexData] <= 24, 266] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[271]))
  iv5Out[tolower(odk[, indexData]) == "hospital", 271] <- "y"
  iv5Out[tolower(odk[, indexData]) == "other_health_facility", 
         271] <- "y"
  iv5Out[tolower(odk[, indexData]) == "home", 271] <- "n"
  iv5Out[tolower(odk[, indexData]) == "on_route_to_hospital_or_facility", 
         271] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other", 271] <- "n"
  iv5Out[tolower(odk[, indexData]) == "hospital", 272] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other_health_facility", 
         272] <- "n"
  iv5Out[tolower(odk[, indexData]) == "home", 272] <- "y"
  iv5Out[tolower(odk[, indexData]) == "on_route_to_hospital_or_facility", 
         272] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other", 272] <- "n"
  iv5Out[tolower(odk[, indexData]) == "hospital", 273] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other_health_facility", 
         273] <- "n"
  iv5Out[tolower(odk[, indexData]) == "home", 273] <- "n"
  iv5Out[tolower(odk[, indexData]) == "on_route_to_hospital_or_facility", 
         273] <- "y"
  iv5Out[tolower(odk[, indexData]) == "other", 273] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[281]))
  iv5Out[tolower(odk[, indexData]) == "first", 281] <- "y"
  iv5Out[tolower(odk[, indexData]) == "second_or_later", 281] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[283]))
  iv5Out[tolower(odk[, indexData]) == "after_delivery", 283] <- "y"
  iv5Out[tolower(odk[, indexData]) == "during_delivery", 283] <- "y"
  indexDatam <- which(stri_endswith_fixed(odkNames, whoNames[284]))
  indexDatad <- which(stri_endswith_fixed(odkNames, "id10359"))
  nMonths <- odk[, indexDatam]
  nDays <- odk[, indexDatad]
  nMonths[is.na(nMonths) & !is.na(nDays)] <- 0
  nDays[is.na(nDays) & !is.na(nMonths)] <- 0
  iv5Out[nMonths + nDays/30.4 <= 12, 284] <- "y"
  iv5Out[nMonths + nDays/30.4 > 12, 284] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[285]))
  iv5Out[tolower(odk[, indexData]) == "hospital", 285] <- "y"
  iv5Out[tolower(odk[, indexData]) == "other_health_facility", 
         285] <- "y"
  iv5Out[tolower(odk[, indexData]) == "home", 285] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other", 285] <- "n"
  iv5Out[tolower(odk[, indexData]) == "on_route_to_hospital_or_facility", 
         285] <- "n"
  iv5Out[tolower(odk[, indexData]) == "hospital", 286] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other_health_facility", 
         286] <- "n"
  iv5Out[tolower(odk[, indexData]) == "home", 286] <- "y"
  iv5Out[tolower(odk[, indexData]) == "other", 286] <- "n"
  iv5Out[tolower(odk[, indexData]) == "on_route_to_hospital_or_facility", 
         286] <- "n"
  iv5Out[tolower(odk[, indexData]) == "hospital", 287] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other_health_facility", 
         287] <- "n"
  iv5Out[tolower(odk[, indexData]) == "home", 287] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other", 287] <- "y"
  iv5Out[tolower(odk[, indexData]) == "on_route_to_hospital_or_facility", 
         287] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[293]))
  iv5Out[odk[, indexData] >= 9 & odk[, indexData] < 88, 293] <- "y"
  iv5Out[odk[, indexData] < 9, 293] <- "n"
  iv5Out[odk[, indexData] > 8 & odk[, indexData] < 88, 294] <- "n"
  iv5Out[odk[, indexData] == 8, 294] <- "y"
  iv5Out[odk[, indexData] < 8, 294] <- "n"
  iv5Out[odk[, indexData] >= 8 & odk[, indexData] < 88, 295] <- "n"
  iv5Out[odk[, indexData] < 8, 295] <- "y"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[304]))
  iv5Out[odk[, indexData] > 24, 304] <- "y"
  iv5Out[odk[, indexData] <= 24, 304] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[307]))
  iv5Out[tolower(odk[, indexData]) == "green_or_brown", 307] <- "y"
  iv5Out[tolower(odk[, indexData]) == "clear", 307] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other", 307] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[313]))
  iv5Out[odk[, indexData] == 0, 313] <- "y"
  iv5Out[odk[, indexData] > 0, 313] <- "n"
  iv5Out[odk[, indexData] >= 4, 314] <- "y"
  iv5Out[odk[, indexData] < 4, 314] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[331]))
  iv5Out[tolower(odk[, indexData]) == "chewing_tobacco", 331] <- "y"
  iv5Out[tolower(odk[, indexData]) == "cigarettes", 331] <- "n"
  iv5Out[tolower(odk[, indexData]) == "pipe", 331] <- "n"
  iv5Out[tolower(odk[, indexData]) == "local_form_of_tobacco", 
         331] <- "n"
  iv5Out[tolower(odk[, indexData]) == "other", 331] <- "n"
  indexData <- which(stri_endswith_fixed(odkNames, whoNames[332]))
  iv5Out[odk[, indexData] >= 10, 332] <- "y"
  iv5Out[odk[, indexData] < 10, 332] <- "n"
  numNA <- colSums(is.na(iv5Out))
  indexNA <- which(numNA > 0)
  if (length(indexNA) > 0) {
    warning("NA's included in output", call. = FALSE)
    cat(paste("odk2openVA produced NA's in the following columns", 
              " (this may cause errors with openVA)", sep = ""), 
        sep = "\n")
    cat(paste(iv5Names[indexNA], " Probably associated with WHO column containing: ", 
              whoNames[indexNA], sep = ""), sep = "\n")
  }
  iv5Out <- cbind(as.character(odk$instanceid), iv5Out)
  colnames(iv5Out) <- c("ID", iv5Names)
  return(as.data.frame(iv5Out, stringsAsFactors = FALSE))
}

#run interva and insilico data conversion and mapping
vadata_int = Converter(vadata)
#unique(unlist(vadata_int))
#write the output to CSV
#write.csv(vadata_int, row.names = F, "vadata_mapped_zm.csv")

#run interva COD
fit_int = codeVA(vadata_int,data.type = "WHO2016", model = "InterVA",directory=".",file="cod_int5_zm",
                 Malaria = "l", HIV = "h",version = "5.0",output="extended")

cod_int = read.csv("cod_int5_zm.csv", stringsAsFactors = F)
cod_int = cod_int[,c('ID','MALPREV','HIVPREV','CAUSE1','LIK1','CAUSE2','LIK2','COMCAT','COMNUM')]
cod_int$CAUSE1[which(cod_int$CAUSE1==' ')]='Indeterminate'
cod_int$CAUSE1 = trimws(cod_int$CAUSE1)

#rub insilico COD
vadata_ins =vadata_int
colnames(vadata_ins) = tolower(colnames(vadata_ins))
fit_ins = codeVA(vadata_ins,data.type = "WHO2016", model = "InSilicoVA",directory=".",
                 Nsim = 1000 ,Malaria = "h", HIV = "h")

#getIndivProb()
ins_cod = getTopCOD(fit_ins)

merge_cod = merge(cod_int,ins_cod, by.y = "ID")
colnames(merge_cod) = tolower(colnames(merge_cod))

write.csv(merge_cod, row.names = F, "merged_cod.csv")






