#!/usr/bin/env python
# coding: utf-8

##restore db file before starting/running this file
import pandas as pd
import numpy as np
import sqlite3,datetime,glob,os,subprocess
from sqlalchemy import create_engine
import psycopg2 as pg
import pandas.io.sql as psql


#host = "10.2.168.18"
connection = pg.connect(user = "yourdbusernaame",
                                  password = "yourdbpassword",
                                  host = "127.0.0.1",
                                  port = "5432",
                                  database = "yourdatabase")
engine = create_engine('postgresql://yourdbusernaame:yourdbpassword@127.0.0.1:5432/yourdatabase')


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
                #connection.close()
                #print("PostgreSQL connection is closed")
    
Initialize('no')

def InitializeDB(init_status):
    if init_status=='yes':
        try:
            
            cur = connection.cursor()            
            cur.execute("CALL public.clear_tables()",connection)
            connection.commit()
            
            cur.execute("CALL public.InitializeDB_Items()",connection)
            connection.commit()
            
        except (Exception, psycopg2.DatabaseError) as error :
            print ("Error while creating/adding PostgreSQL user table", error)
        finally:
            #closing database connection.
            if(connection):
                cur.close()
                
InitializeDB('no')


os.getcwd()
#link = os.getcwd()+"\\smartvacod\\"+"1-individual-cause-of-death\\individual-cause-of-death.csv"
#link

#RUN R combineVA data 
subprocess.call("zmdata.bat")

#RUN R combineVA data 
subprocess.call("R_combined.bat")

#read VA Data to temp and field data
psql.execute("CALL public.main_process()",connection)
connection.commit()
print("proceesed insert transition...")


#save CSV DATA FOR COD
vaclean = psql.read_sql("SELECT * FROM vadata_clean where instanceid not in (SELECT id FROM vacod)", connection)
vaclean.to_csv("vaclean.csv",index=False)
print("selected clean for cod...")


#RUN R COD
subprocess.call("R_who_cod.bat")
#print("cod completed")

connection.close()

#SAVE COD TO DB
#link = os.getcwd()+"\\smartvacod\\"+"1-individual-cause-of-death\\individual-cause-of-death.csv"
vacod = pd.read_csv("merged_cod.csv", low_memory=False)
#smartvacod = pd.read_csv(link, low_memory=False)
list1=[]
lcol = vacod.columns.tolist()
for i in range(0,len(lcol)):
    lcol[i]=lcol[i].lower()
    st2= lcol[i].split("-")[len(lcol[i].split("-"))-1]
    list1.append(st2)
    #print(c)
list1
vacod.columns = list1


vacod.rename(columns = {'cause':'insilico'}, inplace = True)
connection = pg.connect(user = "yourdbusernaame",
                                  password = "yourdbpassword",
                                  host = "127.0.0.1",
                                  port = "5432",
                                  database = "yourdatabase")
engine = create_engine('postgresql://yourdbusernaame:yourdbpassword@127.0.0.1:5432/yourdatabase')

vacod.to_sql("vacod", con = engine, if_exists="append")

print("finished...")
psql.execute("CALL public.remove_duplicates()",connection)
connection.commit()

connection.close()

