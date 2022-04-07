import pandas as pd
import sys
import json

dfc = pd.read_csv(str(sys.argv[1]), skiprows=[1])
dfc = dfc[['SIS User ID', 'Final Points', 'Final Score']]

dfz = pd.read_csv(str(sys.argv[2]))

df2 = pd.DataFrame()
df2['First name'] = dfz['First name']
df2['Last name'] = dfz['Last name']
df2['Email'] = dfz['School email']
df2['Student ID'] = dfz['Student ID']
df2["Participation total"] = dfz.loc[:, dfz.columns.str.match("(Participation total)(?!.time)(.+)")]
df2["Challenge total"] = dfz.loc[:, dfz.columns.str.match("(Challenge total)(?!.time)(.+)")]
df2["Lab total"] = dfz.loc[:, dfz.columns.str.match("(Lab total)(?!.time)(.+)")]

df2 = df2[['First name', 'Last name', 'Email', 'Student ID', 'Participation total', 'Challenge total', 'Lab total']]

df3 = dfc.join(df2)

df3['Risk'] = (((float(sys.argv[3])*df2['Participation total'] + float(sys.argv[4])) / float(sys.argv[5])) + ((float(sys.argv[6])*df2['Challenge total'] + float(sys.argv[7])) /float(sys.argv[8])) + ((float(sys.argv[9])*df2['Lab total']+float(sys.argv[10])) /float(sys.argv[11]))).round(2)

stats = {'Student count': len(df3),
         'At risk': float((df3['Risk'] > 30).sum()),
         'Participation average': float(df2['Participation total'].mean().round(2)),
         'Challenge average': float(df2['Challenge total'].mean().round(2)),
         'Lab average': float(df2['Lab total'].mean().round(2))
        }
stats_json = json.dumps(stats)

print(stats_json)