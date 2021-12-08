import mysql.connector
import numpy as np
 

mydatabase = mysql.connector.connect(
    host = "localhost",
    user = "root",
    passwd = "",
    database = "COVID"
)
 
cursor = mydatabase.cursor()
nfc_id=np.arange(1003,2003)
service_id=[4,4,4,4,8]
place_id=[412,413,414,415]
amount=np.arange(100,200)
year=[2020,2021]
month=np.arange(1,12)
day=np.arange(1,28)
hour=np.arange(8,22)
minutes=np.arange(0,59)
seconds=np.arange(0,59)
for i in range(200):
    nfcid=np.random.choice(nfc_id)
    print(nfcid)
    serviceid=np.random.choice(service_id)
    amount1=np.random.choice(amount)
    if (serviceid==4):
        placeid=np.random.choice(place_id)
        description='restaurant'
    else:
        placeid=440
        description='hair salon'
    y = np.random.choice(year)
    m = np.random.choice(month)
    d = np.random.choice(day)
    h = np.random.choice(hour)
    mi = np.random.choice(minutes)
    sec = np.random.choice(seconds)
    date_of_entrance = "-".join([str(y),str(m),str(d)])
    time_of_entrance = ":".join([str(h),str(mi),str(sec)])
    time_of_exit = ":".join([str(h+2),str(mi),str(sec)])
    sql="""INSERT INTO visit (nfc_id,place_id,date_of_entrance,time_of_entrance,date_of_exit,time_of_exit)
            VALUES(%s,%s,%s,%s,%s,%s)"""
    data=(str(nfcid),str(placeid),date_of_entrance,time_of_entrance,date_of_entrance,time_of_exit)
    cursor.execute(sql,data)
    mydatabase.commit()
    sql="""INSERT INTO service_charge (amount,description_of_charge,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
    data=(str(amount1),description,date_of_entrance,time_of_exit)
    cursor.execute(sql,data)
    mydatabase.commit()
    sql="""INSERT INTO enjoy_services (nfc_id,service_id,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
    data=(str(nfcid),str(serviceid),date_of_entrance,time_of_exit)
    cursor.execute(sql,data)
    mydatabase.commit()
print("done")
