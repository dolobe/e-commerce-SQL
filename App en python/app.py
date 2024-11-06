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

def fetch_data(table_name, search_query=""):
    connection = get_database_connection()
    if connection:
        try:
            query = f"SELECT * FROM {table_name}"
            if search_query:
                query += f" WHERE CONCAT_WS(' ', *) LIKE '%{search_query}%'"
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

# Sélection de la table
tables = get_table_list()
if tables:
    table_name = st.selectbox("Sélectionnez une table à afficher", tables)
    
    # Barre de recherche
    search_query = st.text_input("Recherche", placeholder="Entrez un terme pour rechercher dans la table...")

    if table_name:
        # Récupération et affichage des données
        df = fetch_data(table_name, search_query)
        if df is not None:
            st.write(f"Données récupérées depuis la table '{table_name}' :")
            # Afficher les données dans un tableau
            st.dataframe(df)

            # Pour chaque ligne, ajouter des boutons d'action
            for i in range(len(df)):
                row = df.iloc[i]
                cols = st.columns((1, 1, 1))  # Ajuster la taille des colonnes pour les boutons

                # Bouton Ajouter
                if cols[0].button("Ajouter", key=f"add_{i}"):
                    with st.form(f"add_form_{i}"):
                        st.write("Ajouter une nouvelle entrée dans la table")
                        new_data = {}
                        for column in df.columns:
                            new_data[column] = st.text_input(f"{column}", "")
                        submit_add = st.form_submit_button("Ajouter")
                        if submit_add:
                            try:
                                connection = get_database_connection()
                                cursor = connection.cursor()
                                columns = ", ".join(new_data.keys())
                                values = ", ".join(["%s"] * len(new_data))
                                query = f"INSERT INTO {table_name} ({columns}) VALUES ({values})"
                                cursor.execute(query, list(new_data.values()))
                                connection.commit()
                                st.success("Nouvelle entrée ajoutée avec succès.")
                            except Exception as e:
                                st.error(f"Erreur lors de l'ajout des données : {e}")
                            finally:
                                connection.close()
                
                # Bouton Modifier
                if cols[1].button("Modifier", key=f"edit_{i}"):
                    with st.form(f"edit_form_{i}"):
                        st.write("Modifier les données de la ligne")
                        updated_data = {}
                        for column in df.columns:
                            updated_data[column] = st.text_input(f"{column}", row[column])
                        submit_edit = st.form_submit_button("Confirmer la modification")
                        if submit_edit:
                            try:
                                connection = get_database_connection()
                                cursor = connection.cursor()
                                set_values = ", ".join([f"{col} = %s" for col in updated_data.keys()])
                                query = f"UPDATE {table_name} SET {set_values} WHERE id = %s"  # Remplacez 'id' par la clé primaire de votre table
                                cursor.execute(query, list(updated_data.values()) + [row['id']])  # 'id' est supposé être la clé primaire
                                connection.commit()
                                st.success("Modification effectuée avec succès.")
                            except Exception as e:
                                st.error(f"Erreur lors de la modification des données : {e}")
                            finally:
                                connection.close()

                # Bouton Supprimer
                if cols[2].button("Supprimer", key=f"delete_{i}"):
                    confirm_delete = st.confirm("Êtes-vous sûr de vouloir supprimer cette entrée?")
                    if confirm_delete:
                        try:
                            connection = get_database_connection()
                            cursor = connection.cursor()
                            query = f"DELETE FROM {table_name} WHERE id = %s"  # Remplacez 'id' par la clé primaire de votre table
                            cursor.execute(query, (row['id'],))
                            connection.commit()
                            st.success("Suppression effectuée avec succès.")
                        except Exception as e:
                            st.error(f"Erreur lors de la suppression des données : {e}")
                        finally:
                            connection.close()
            
            # Option d'ajout d'une nouvelle ligne en dehors de la boucle
            if st.button("Ajouter une nouvelle entrée"):
                with st.form("add_data_form"):
                    st.write("Ajouter une nouvelle entrée dans la table")
                    new_data = {}
                    for column in df.columns:
                        new_data[column] = st.text_input(f"{column}", "")
                    submitted = st.form_submit_button("Ajouter")
                    if submitted:
                        try:
                            connection = get_database_connection()
                            cursor = connection.cursor()
                            columns = ", ".join(new_data.keys())
                            values = ", ".join(["%s"] * len(new_data))
                            query = f"INSERT INTO {table_name} ({columns}) VALUES ({values})"
                            cursor.execute(query, list(new_data.values()))
                            connection.commit()
                            st.success("Nouvelle entrée ajoutée avec succès.")
                        except Exception as e:
                            st.error(f"Erreur lors de l'ajout des données : {e}")
                        finally:
                            connection.close()
        else:
            st.write("Aucune donnée n'a été récupérée.")
else:
    st.write("Aucune table disponible dans la base de données.")
