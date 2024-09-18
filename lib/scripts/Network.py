##Script provides interactive network consisting of keywords and titles of web pages saved in FaroLi repository
##Commands for virtual environment configuration using conda for this script is in config/Conda_Environment_Python.txt
##After running this script, place the resulting folders in "lib" folder and "network.html" in root of FaroLi repository app
##Resulting network.html is loaded as iframe in CLUSTER NETWORK part of index.php page

##LIBRARIES IMPORT
import psycopg2 as postgr
import pandas as pd 
from pyvis.network import Network


##DB CONNECTION & REPOSITORY DATA DOWNLOAD 
servername = "localhost";
username_r = "Add_Web_Reader_Name_Here";
password_r = "Add_Web_Reader_Password_Here";
dbname = "faroli_repository";
port = "5432";

conn = postgr.connect(database = dbname, 
                     host = servername,
                     user = username_r,
                     password = password_r,
                     port = port)

cur = conn.cursor()
cur.execute('SELECT title, keywords FROM repository ORDER BY title ASC;')

repository_data = cur.fetchall()

conn.commit()
conn.close()
print (f" Recorded {len(repository_data)} lines from DB")


##SPLITS KEYWORDS & SHORTENS TITLES AND KEYWORDS TO 20 CHARACTERS
key_list = []
titles = []
keywords = []
for row in repository_data:
    title_slice = row[0][:20]
    key_list = row[1].split(",")
    for key in key_list: 
        single_key = key.lower()
        single_key = single_key.strip()
        if len(single_key) != 0:
            single_key_slice = single_key[:20]
            titles.append(title_slice.upper())
            keywords.append(single_key_slice)

#CREATES BASE DATAFRAME  
data = {
    "titles": titles, 
    "keywords": keywords
    }

graph_data = pd.DataFrame(data)
#counts and adds info about number of occurence in dataframe for each keyword; can be used for line weight in network
occurence_list = graph_data["keywords"].value_counts(dropna=True) 
graph_data["occurence"] = graph_data["keywords"].map(occurence_list)

#FILTERS DATAFRAME KEEPS LINES WHERE KEYWORD OCCURENCE IS MORE THAN 1
graph_data = graph_data.loc[graph_data["occurence"] > 1]
print(f"List for networkgraph has {len(graph_data)} rows.")


##CREATES NETWORK PLOT using PyVis
net = Network(notebook=True, bgcolor="#012d43", font_color="#ebebeb")

graph_data.reset_index()
for line in graph_data.index:
    net.add_node(n_id=graph_data["keywords"][line], label=graph_data["keywords"][line], shape="dot", color="#6a1600", size=10)
for line in graph_data.index:
    net.add_node(n_id=graph_data["titles"][line], label=graph_data["titles"][line], shape="dot", color="#6a1600", size=10)

for line in graph_data.index:
    net.add_edge(graph_data["keywords"][line], graph_data["titles"][line], title=graph_data["titles"][line], color="#ebebeb")

net.barnes_hut(overlap=1)

net.set_options("""
    const options = {
      "nodes": {
        "font": {
          "face": "Arial",
          "size": 25
        },
        "shadow": {
          "enabled": true
        }
      },
      "edges": {
        "font": {
          "face": "Arial",
          "size": 14
        },
        "shadow": {
          "enabled": true
        }
      }
    }                
""")

net.show("network.html")