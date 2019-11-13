#!/usr/bin/env python
# coding: utf-8

# In[60]:


import pandas as pd
import numpy as np
import sqlite3,datetime,os,psycopg2
import shutil
from sqlalchemy import create_engine

#destination of database: dashboard website link
connection = psycopg2.connect(user = "demova",
                                  password = "demova",
                                  host = "127.0.0.1",
                                  port = "5432",
                                  database = "demova")

engine = create_engine('postgresql://demova:demova@127.0.0.1:5432/demova')
#create file-- for first time use only: this will clear the db if it exists



def Initialize(init_status):
    if init_status=='yes':
        try:
            cur = connection.cursor()
            cur.execute("CREATE TABLE if not exists public.users(username TEXT not null,email TEXT not null,phonenumber TEXT not null,usergroup TEXT NOT NULL,Password TEXT not null,uid serial primary key);")
            connection.commit()
            print("created table users sucessfully")
            
            cur.execute("insert into public.users values('admin','qollinsochieng@gmail.com','254702344393','Administrator','$2y$10$tPuDKc4oUtHQOWI7iqbBFOCyLM.vI1qTSNHwP/Ka2Z97/NQ2s8IMG',1)")
            print("inserted user sucessfully")
            connection.commit()
        except (Exception, psycopg2.DatabaseError) as error :
            print ("Error while creating/adding PostgreSQL user table", error)
        finally:
            #closing database connection.
            if(connection):
                cur.close()
                connection.close()
                print("PostgreSQL connection is closed")
    
        
Initialize('yes')


vadata = pd.read_csv("merged_cod_va.csv", low_memory=False)
pd.set_option('mode.chained_assignment', None)

#def renameColumns():
print("renaming columns...")
list1=[]
lcol = vadata.columns.tolist()
for i in range(0,len(lcol)):
    lcol[i]=lcol[i].lower()
    st2= lcol[i].split("-")[len(lcol[i].split("-"))-1]
    list1.append(st2)
    #print(c)
list1
vadata.columns = list1


vadata['submissiondate'][vadata['submissiondate']=''] = vadata['id10012']


#def formatDates():
from datetime import datetime
pd.set_option('mode.chained_assignment', None)
#datetime.strptime('15/02/2016', '%d/%m/%Y')
#datetime.strptime('2017-06-29T00:00:00.000', '%Y-%m-%dT00:00:00.000')
vadata['id10023'][vadata['id10023'].isnull()]='01-01-1970'
for i in range(1,len(vadata['id10023'])):
    if vadata['id10023'][i].find('T')>0:
        dt23 = datetime.strptime((vadata['id10023'][i])[0:vadata['id10023'][i].find('T')],'%Y-%m-%d')
        vadata['id10023'][i]= datetime.strftime(dt23,'%Y-%m-%d')
    
    if vadata['id10023'][i].find('/')>0:
        vadata['id10023'][i]=datetime.strftime(datetime.strptime(vadata['id10023'][i], '%d/%m/%Y'),'%d-%m-%Y')

for i in range(1,len(vadata['submissiondate'])):
    if vadata['submissiondate'][i].find('T')>0:
        dtsb = datetime.strptime((vadata['submissiondate'][i])[0:vadata['submissiondate'][i].find('T')],'%Y-%m-%d')
        vadata['submissiondate'][i]= datetime.strftime(dtsb,'%Y-%m-%d')
    
    if vadata['submissiondate'][i].find('/')>0:
        vadata['submissiondate'][i]=datetime.strftime(datetime.strptime(vadata['submissiondate'][i], '%d/%m/%Y'),'%d-%m-%Y')


lcol = vadata.columns.tolist()
for i in range(1,len(lcol)):
    lcol[i]=lcol[i].lower()
    #print(c)
vadata.columns = lcol

vadata['submissiondate'][vadata['submissiondate'].isnull()]= pd.to_datetime(vadata['id10481'][vadata['submissiondate'].isnull()])
vadata['submissiondate'][vadata['submissiondate'].isnull()]= pd.to_datetime(vadata['id10012'][vadata['submissiondate'].isnull()])

vadata['dodyear'] = pd.DatetimeIndex(vadata['id10023']).year
vadata['dodmonth'] = pd.DatetimeIndex(vadata['id10023']).month
vadata['year'] = pd.DatetimeIndex(vadata['submissiondate']).year
vadata['month'] = pd.DatetimeIndex(vadata['submissiondate']).month

vadata['year'] = pd.to_numeric(vadata['year'], downcast='integer')
vadata['month'] = pd.to_numeric(vadata['month'], downcast='integer')
vadata['dodyear'] = pd.to_numeric(vadata['dodyear'], downcast='integer')
vadata['dodmonth'] = pd.to_numeric(vadata['dodmonth'], downcast='integer')

vadata['submissiondate'] = pd.to_datetime(vadata['submissiondate'])
vadata.to_sql("vadata", con = engine, if_exists="replace")


forms = vadata[{"ischild","isadult","isneonatal","age_group"}]

numChild = len(forms[forms["ischild"]==1.0])+len(forms[forms["age_group"]=="child"])
numAdult = len(forms[forms["isadult"]==1.0])+len(forms[forms["age_group"]=="adult"])
numNeon = len(forms[forms["isneonatal"]==1.0])+len(forms[forms["age_group"]=="neonate"])
numNone =  len(forms[(forms["isneonatal"]=='') & (forms["isadult"]=='') & (forms["ischild"]=='')])
CntForms = pd.DataFrame({"forms":["Adult","Child","Neonate","Total"],
                        "count":[numAdult, numChild,numNeon, (numAdult+numChild+numNeon)]})
CntForms.to_sql("cntforms", con = engine, if_exists="replace")

CntForms


def InsertErrors(col,filenum,errmsg,df):
    #df = pd.DataFrame(columns=['column','filenum','error_message'])
    df=df.append({'column':col,'id':filenum,'error_message':errmsg}, ignore_index=True)
    return df


subs = vadata[{'id','id10010','id10017'}]
errors = pd.DataFrame(columns=['column','id','error_message'])
duplicates = subs[subs.duplicated(['id', 'id10010'], keep=False)]

for i in range(0,len(vadata['id'])-1):

    if (vadata['id'][i] in list(duplicates['id'])) and not(vadata['id'][i] in list(errors['id'])):
        errors =InsertErrors('id',vadata['id'][i],'duplicated key',errors)
    if vadata['id10366'][i] <500:
        errors =InsertErrors('id10366 weight in grammes',vadata['id'][i],'invalid weight in grammes '+str(vadata['id10366'][i]),errors)
    if vadata['id10019'][i] =='' or pd.isnull(vadata['id10019'][i]):
        errors =InsertErrors('id10019 Gender',vadata['id'][i],'Missing gender ',errors)
        
    if vadata['isadult'][i] =='' and vadata['ischild'][i] =='' and vadata['isneonatal'][i] =='' and vadata['age_group'][i]:
        errors =InsertErrors('age group',vadata['id'][i],'Missing age group ',errors)
        
    if vadata['id10010'][i] =='' or pd.isnull(vadata['id10010'][i]):
        errors =InsertErrors('interviewer name id10010',vadata['id'][i],'Missing '+str(vadata['id10010'][i]),errors)

errors.to_sql("errors", con = engine, if_exists="replace")
errors



CntForms.to_sql("cntforms", con = engine, if_exists="replace")
vadata.to_sql("vadata", con = engine, if_exists="replace")



vadata['id10010'][vadata['id10010'].isna()]=""
vadata['ischild'][vadata['ischild'].isna()]=""
vadata['isadult'][vadata['isadult'].isna()]=""
vadata['isneonatal'][vadata['isneonatal'].isna()]=""



#InterViewers monthly distribution
vadata['ischild'][vadata['age_group']=='child'] = "Child"
vadata['isadult'][vadata['age_group']=='adult'] = "Adult"
vadata['isneonatal'][vadata['age_group']=='neonate'] = "Neonate"

vadata['ischild'] = vadata['ischild'].replace(1.0,"Child")
vadata['ischild'] = vadata['ischild'].replace(0.0,"")
vadata['isadult'] = vadata['isadult'].replace(1.0,"Adult")
vadata['isadult'] = vadata['isadult'].replace(0.0,"")
vadata['isneonatal'] = vadata['isneonatal'].replace(1.0,"Neonate")
vadata['isneonatal'] = vadata['isneonatal'].replace(0.0,"")



vadata['agegroup'] = vadata['ischild'] + vadata['isadult'] + vadata['isneonatal'] 
vadata[{"ischild","isadult","isneonatal","age_group","agegroup"}]



vadata['agegroup'] = vadata['ischild'] + vadata['isadult'] + vadata['isneonatal']
numInterviews = vadata[{"id10010","id10012","dodyear","dodmonth","year","month","agegroup","id10019"}]
#numInterviews.head()


#def MonthlyReportCnt():
numInterviews.groupby("month").size().reset_index(name='counts')
monthlyReportCnt = numInterviews.groupby(["year","month"]).size().reset_index(name='counts')
monthlyReportCnt['month'] = pd.to_numeric(monthlyReportCnt['month'], downcast = "integer")
monthlyReportCnt['year'] = pd.to_numeric(monthlyReportCnt['year'], downcast = "integer")
monthlyReportCnt.to_sql("monthlyreportcnt", con = engine, if_exists="replace")
#monthlyReportCnt


#def MonthlySummaryByAgeGroup():
#VA Monthly summary by Age Group: submission date
numInterviews.groupby("dodmonth").size().reset_index(name='counts')
monthlyReportGA = numInterviews.groupby(["dodyear","dodmonth","id10019",'agegroup']).size().reset_index(name='counts')
monthlyReportGA['dodmonth'] = pd.to_numeric(monthlyReportGA['dodmonth'], downcast = "integer")
monthlyReportGA['dodyear'] = pd.to_numeric(monthlyReportGA['dodyear'], downcast = "integer")
monthlyReportGA.to_sql("monthlyreportga", con = engine, if_exists="replace")
#monthlyReportGA.head()


#def ViewVAGender():
#gender
viewvaGender = vadata.groupby("id10019").size().reset_index(name='counts')
viewvaGenderAge = vadata[{'id10019','agegroup'}]
viewvaGenderAge = viewvaGenderAge.groupby(["id10019","agegroup"]).size().reset_index(name='counts')
viewvaGenderAge.to_sql("viewvagenderage", con = engine, if_exists="replace")


#coddata = vadata  
csmf_Interva =  vadata.groupby(["interva5"]).size().reset_index(name='counts')
csmf_Interva.to_sql("csmf_Interva", con = engine, if_exists="replace")

csmf_Ins =  vadata.groupby(["insilico"]).size().reset_index(name='counts')
csmf_Ins.to_sql("csmf_ins", con = engine, if_exists="replace")



csmfInt5AgeGroup = vadata.groupby(['dodyear','agegroup','interva5']).size().reset_index(name='counts')
csmfInt5AgeGroup


#def CsmfSummary():
print("csmf summary...")
csmfInt5AgeGroup = vadata.groupby(['dodyear','agegroup','interva5']).size().reset_index(name='counts')
csmfInt5AgeGroup.to_sql("csmfint5agegroup", con = engine, if_exists="replace")

csmfInsAgeGroup = vadata.groupby(['dodyear','agegroup','insilico']).size().reset_index(name='counts')
csmfInsAgeGroup.to_sql("csmfinsagegroup", con = engine, if_exists="replace")
#csmfInt5AgeGroup.head()

csmfInt5Sex = vadata.groupby(['dodyear','id10019','interva5']).size().reset_index(name='counts')
csmfInt5Sex.to_sql("csmfint5sex", con = engine, if_exists="replace")

csmfInsSex = vadata.groupby(['dodyear','id10019','insilico']).size().reset_index(name='counts')
csmfInsSex.to_sql("csmfinssex", con = engine, if_exists="replace")
#csmfInt5Sex.head()


csmflocIns = vadata.groupby(['id10057','insilico']).size().reset_index(name='counts')
csmflocIns.to_sql("csmflocins", con = engine, if_exists="replace")

csmflocInt5 = vadata.groupby(['id10057','interva5']).size().reset_index(name='counts')
csmflocInt5.to_sql("csmflocint5", con = engine, if_exists="replace")


#def UndeterminedVA():
undet = vadata[(vadata['interva5']=='Undetermined') | (vadata['interva5']=='Cause of death unknown')]
undet = undet.groupby(['id10010','dodyear']).size().reset_index(name='counts')
undet.to_sql("undetermined", con = engine, if_exists="replace")
#undet

print("completed successfully!...")

connection.close()




