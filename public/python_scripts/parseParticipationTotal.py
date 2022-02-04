import pandas as pd
import sys

df = pd.read_csv(str(sys.argv[1]))

df2 = pd.DataFrame()
df2['Primary email'] = df['Primary email']
df2['Participation total'] = df.loc[:, df.columns.str.match('(Participation total)(?!.time)(.+)')]

json = df2[['Primary email', 'Participation total']].to_json(orient='index')
print(json)