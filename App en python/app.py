import streamlit as st
import mysql.connector
import pandas as pd

def get_database_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            port="3306",
            user="root",
            password="",
            database="e-commerce-sql"
        )
        return connection
    except mysql.connector.Error as err:
        st.error(f"Erreur de connexion à la base de données: {err}")
        return None

def get_table_list():
    connection = get_database_connection()
    if connection:
        try:
            cursor = connection.cursor()
            cursor.execute("SHOW TABLES")
            tables = [table[0] for table in cursor.fetchall()]
            return tables
        except Exception as e:
            st.error(f"Erreur lors de la récupération des tables : {e}")
            return []
        finally:
            connection.close()
    else:
        return []

def fetch_data(table_name):
    connection = get_database_connection()
    if connection:
        try:
            query = f"SELECT * FROM {table_name}"
            df = pd.read_sql(query, connection)
            return df
        except Exception as e:
            st.error(f"Erreur lors de la récupération des données : {e}")
            return None
        finally:
            connection.close()
    else:
        return None

st.title("Affichage des données depuis MySQL")

tables = get_table_list()
if tables:
    table_name = st.selectbox("Sélectionnez une table à afficher", tables)
    
    if table_name:
        df = fetch_data(table_name)
        if df is not None:
            st.write(f"Données récupérées depuis la table '{table_name}' :")
            st.dataframe(df)
        else:
            st.write("Aucune donnée n'a été récupérée.")
else:
    st.write("Aucune table disponible dans la base de données.")
