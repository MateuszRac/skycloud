import pandas as pd
import os
from dotenv import load_dotenv
import requests

from jinja2 import Environment, FileSystemLoader


load_dotenv()
PROJECT_PATH = os.getenv("project_path")
PROJECT_PATH = os.path.normpath(PROJECT_PATH)

TEMPLATE_DIR = os.path.join(PROJECT_PATH, "html")
WWW_PATH  = os.getenv('www_path')
WWW_PATH = os.path.normpath(WWW_PATH)


# Send GET request
url = 'https://danepubliczne.imgw.pl/api/data/meteo/'
response = requests.get(url)
response.raise_for_status()
data = response.json()


df = pd.DataFrame(data)

env = Environment(loader=FileSystemLoader(TEMPLATE_DIR))

template = env.get_template('template_index.php')

# Render the template
html = template.render(
    title="IMGW",
    columns=df.columns.tolist(),
    rows=df.values.tolist()
)

# Save output
output_file = os.path.join(WWW_PATH,"index.php")
with open(output_file, "w", encoding="utf-8") as f:
    f.write(html)

print(f"HTML written to {output_file}")
