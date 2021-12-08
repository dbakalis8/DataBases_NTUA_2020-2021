import mysql.connector
import numpy as np
import array
import random

 

mydatabase = mysql.connector.connect(
    host = "localhost",
    user = "root",
    passwd = "",
    database = "COVID"
)

check=4000*[None]
flag=0
cursor = mydatabase.cursor()
year=[2020,2021]
month=np.arange(1,12)
day=np.arange(1,28)
hour=np.arange(8,22)
minutes=np.arange(0,59)
seconds=np.arange(0,59)
nfc_id=np.arange(1000,2000)
room_id1=np.arange(1,400)
room_id=array.array('i',room_id1)
service_id=[1,4,5,6] 
service_id2=[2,3,7]   
amount=np.arange(100,200)
space=np.arange(0,4000)
combinations = [[a, b] for a in nfc_id
          for b in service_id if a != b]
for i in range (0,1000):
    y = np.random.choice(year)
    m = np.random.choice(month)
    d = np.random.choice(day)
    h = np.random.choice(hour)
    mi = np.random.choice(minutes)
    sec = np.random.choice(seconds)
    registration_date1 = "-".join([str(y),str(m),str(d)])
    registration_time1 = ":".join([str(h),str(mi),str(sec)])
    registration_date2 = "-".join([str(y),str(m+(d+5)//28),str((d+5)%28+1)])
    registration_time2 = ":".join([str(h),str(mi),str(sec)])
    c=np.random.choice(space)
    a=combinations[c][0]
    b=combinations[c][1]
    print(a,b)
    for j in range(0,i):
        if (check[j]==c):
            flag=1
    if (flag==0):
        check[i]=c
    else:
        flag=0
        continue
    sql1="""INSERT INTO registrations_to_services (nfc_id,service_id,date_of_registration,time_of_registration)
            VALUES(%s,%s,%s,%s)"""
    data=(str(a),str(b),registration_date1,registration_time1)
    cursor.execute(sql1,data)
    mydatabase.commit()
    if (b==1):
        room=np.random.choice(room_id)
        room_id.remove(room)
        sql2="""INSERT INTO access (nfc_id,place_id,date_of_start,time_of_start,date_of_end,time_of_end)
            VALUES(%s,%s,%s,%s,%s,%s)"""
        data=(str(a),str(room),registration_date1,registration_time1,registration_date2,registration_time2)
        cursor.execute(sql2,data)
        mydatabase.commit()
        for j in range (1,11):
            room=400+j
            sql3="""INSERT INTO access (nfc_id,place_id,date_of_start,time_of_start,date_of_end,time_of_end)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            data=(str(a),str(room),registration_date1,registration_time1,registration_date2,registration_time2)
            cursor.execute(sql3,data)
            mydatabase.commit()
            
            sql5="""INSERT INTO visit (nfc_id,place_id,date_of_entrance,time_of_entrance,date_of_exit,time_of_exit)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            day10=np.arange(d,d+5)
            current_day=np.random.choice(day10)
            date="-".join([str(y),str(m+current_day//28),str(current_day%28+1)])
            current_hour=np.random.choice(hour)
            current_minute=np.random.choice(minutes)
            current_second=np.random.choice(seconds)
            time=":".join([str(current_hour),str(current_minute),str(current_second)])
            exit_time=":".join([str(current_hour+2),str(current_minute),str(current_second)])
            data=(str(a),str(room),date,time,date,exit_time)
            cursor.execute(sql5,data)
            mydatabase.commit()
            
            sql6="""INSERT INTO service_charge (amount,description_of_charge,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(np.random.choice(amount)),'bar/restaurant',date,exit_time)
            cursor.execute(sql6,data)
            mydatabase.commit()
            
            sql7="""INSERT INTO enjoy_services (nfc_id,service_id,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(a),str(b),date,exit_time)
            cursor.execute(sql7,data)
            mydatabase.commit()
            
        room=440
        sql4="""INSERT INTO access (nfc_id,place_id,date_of_start,time_of_start,date_of_end,time_of_end)
            VALUES(%s,%s,%s,%s,%s,%s)"""
        data=(str(a),str(room),registration_date1,registration_time1,registration_date2,registration_time2)
        cursor.execute(sql4,data)
        mydatabase.commit()
    elif (b==4):
        for j in range (1,11):
            room=415+j
            sql2="""INSERT INTO access (nfc_id,place_id,date_of_start,time_of_start,date_of_end,time_of_end)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            data=(str(a),str(room),registration_date1,registration_time1,registration_date2,registration_time2)
            cursor.execute(sql2,data)
            mydatabase.commit()
            
            sql5="""INSERT INTO visit (nfc_id,place_id,date_of_entrance,time_of_entrance,date_of_exit,time_of_exit)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            day10=np.arange(d,d+5)
            current_day=np.random.choice(day10)
            date="-".join([str(y),str(m+current_day//28),str(current_day%28+1)])
            current_hour=np.random.choice(hour)
            current_minute=np.random.choice(minutes)
            current_second=np.random.choice(seconds)
            time=":".join([str(current_hour),str(current_minute),str(current_second)])
            exit_time=":".join([str(current_hour+2),str(current_minute),str(current_second)])
            data=(str(a),str(room),date,time,date,exit_time)
            cursor.execute(sql5,data)
            mydatabase.commit()
            
            sql6="""INSERT INTO service_charge (amount,description_of_charge,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(np.random.choice(amount)),'conference room',date,exit_time)
            cursor.execute(sql6,data)
            mydatabase.commit()
            
            sql7="""INSERT INTO enjoy_services  (nfc_id,service_id,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(a),str(b),date,exit_time)
            cursor.execute(sql7,data)
            mydatabase.commit()
            
    elif (b==5):
        for j in range (1,5):
            room=425+j
            sql2="""INSERT INTO access (nfc_id,place_id,date_of_start,time_of_start,date_of_end,time_of_end)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            data=(str(a),str(room),registration_date1,registration_time1,registration_date2,registration_time2)
            cursor.execute(sql2,data)
            mydatabase.commit()
            sql5="""INSERT INTO visit (nfc_id,place_id,date_of_entrance,time_of_entrance,date_of_exit,time_of_exit)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            day10=np.arange(d,d+5)
            current_day=np.random.choice(day10)
            date="-".join([str(y),str(m+current_day//28),str(current_day%28+1)])
            current_hour=np.random.choice(hour)
            current_minute=np.random.choice(minutes)
            current_second=np.random.choice(seconds)
            time=":".join([str(current_hour),str(current_minute),str(current_second)])
            exit_time=":".join([str(current_hour+2),str(current_minute),str(current_second)])
            data=(str(a),str(room),date,time,date,exit_time)
            cursor.execute(sql5,data)
            mydatabase.commit()
            sql6="""INSERT INTO service_charge (amount,description_of_charge,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(np.random.choice(amount)),'gym',date,exit_time)
            cursor.execute(sql6,data)
            mydatabase.commit()
            sql7="""INSERT INTO enjoy_services (nfc_id,service_id,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(a),str(b),date,exit_time)
            cursor.execute(sql7,data)
            mydatabase.commit()
            
    elif (b==6):
        for j in range (1,11):
            room=429+j
            sql2="""INSERT INTO access (nfc_id,place_id,date_of_start,time_of_start,date_of_end,time_of_end)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            data=(str(a),str(room),registration_date1,registration_time1,registration_date2,registration_time2)
            cursor.execute(sql2,data)
            mydatabase.commit()
            
            sql5="""INSERT INTO visit (nfc_id,place_id,date_of_entrance,time_of_entrance,date_of_exit,time_of_exit)
            VALUES(%s,%s,%s,%s,%s,%s)"""
            day10=np.arange(d,d+5)
            current_day=np.random.choice(day10)
            date="-".join([str(y),str(m+current_day//28),str(current_day%28+1)])
            current_hour=np.random.choice(hour)
            current_minute=np.random.choice(minutes)
            current_second=np.random.choice(seconds)
            time=":".join([str(current_hour),str(current_minute),str(current_second)])
            exit_time=":".join([str(current_hour+2),str(current_minute),str(current_second)])
            data=(str(a),str(room),date,time,date,exit_time)
            cursor.execute(sql5,data)
            mydatabase.commit()
            
            sql6="""INSERT INTO service_charge (amount,description_of_charge,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(np.random.choice(amount)),'sauna',date,exit_time)
            cursor.execute(sql6,data)
            mydatabase.commit()
            
            sql7="""INSERT INTO enjoy_services  (nfc_id,service_id,date_of_charge,time_of_charge)
            VALUES(%s,%s,%s,%s)"""
            data=(str(a),str(b),date,exit_time)
            cursor.execute(sql7,data)
            mydatabase.commit()
print("done")
