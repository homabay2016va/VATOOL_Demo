##remove everything in environment
rm(list = ls())
setwd("C:\\Users\\Administrator\\Desktop\\OpenVAPipeline")
library('plyr')
library(RPostgreSQL)

#icd10 = read.csv("icd10.csv", stringsAsFactors = F)

v1 = read.csv("va1.csv", stringsAsFactors = F)
colnames(v1) = tolower(names(v1))
header= names(v1)
header_cleaned <- regmatches(header, regexpr("[^\\.]*$", header))
colnames(v1)=c(header_cleaned)

#v2 = read.csv("va5.csv", stringsAsFactors = F)
#colnames(v2) = tolower(names(v2))
#header= names(v2)
#header_cleaned <- regmatches(header, regexpr("[^\\.]*$", header))
#colnames(v2)=c(header_cleaned)

#v3 = read.csv("va3.csv", stringsAsFactors = F)
#colnames(v3) = tolower(names(v3))
#header= names(v3)
#header_cleaned <- regmatches(header, regexpr("[^\\.]*$", header))
#colnames(v3)=c(header_cleaned)

#v4 = read.csv("va4.csv", stringsAsFactors = F)
#colnames(v4) = tolower(names(v4))
#header= names(v4)
#header_cleaned <- regmatches(header, regexpr("[^\\.]*$", header))
#colnames(v4)=c(header_cleaned)

#alldata = rbind.fill(v1,v2,v3,v4)
#alldata[,] <- apply(alldata[ , ], 2, function(x) as.character(x))
v1[,] <- apply(v1[ , ], 2, function(x) as.character(x))


#smartva = read.csv("smartva.csv", stringsAsFactors = F)
#header= names(smartva)
#header_cleaned <- regmatches(header, regexpr("[^\\.]*$", header))
#colnames(smartva)=c(header_cleaned)
#colnames(smartva) = tolower(names(smartva))
#smartva[,] <- apply(smartva[ , ], 2, function(x) as.character(x))

drv <- dbDriver("PostgreSQL")
con <- dbConnect(drv, dbname = "demodb",
                 host = "127.0.0.1", port = 5432,
                 user = "dbusername", password = "dbpassword")
#va = dbSendQuery(con,"select * from vadata")
#va<- dbReadTable(con, "vadata")

#dbWriteTable(con,"icd10",icd10, append=TRUE)

dbWriteTable(con,"vadata_field",v1, append=TRUE)
#dbWriteTable(con,"smartva_field",smartva, append=TRUE)

dbWriteTable(con,"vadata_temp",v1, append=TRUE)
#dbWriteTable(con,"smartva_temp",smartva, append=TRUE)

dbDisconnect(con)

