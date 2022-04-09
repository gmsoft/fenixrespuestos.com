import pandas as pd

url = 'https://drive.google.com/file/d/1PidUnTNoCuLc1rrUTQ-HT17pIAL6-NkH/view?usp=sharing'
file_id = url.split('/')[-2]
# https://drive.google.com/uc?id=1PidUnTNoCuLc1rrUTQ-HT17pIAL6-NkH
dwn_url = 'https://drive.google.com/uc?id=' + file_id
df = pd.read_csv(dwn_url)
print(df.head())

js = df.to_json(orient = 'records')

print(js)

