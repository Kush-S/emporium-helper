import pandas as pd
import sys
import json

dfc = pd.read_csv(str(sys.argv[1]), skiprows=[1])
dfz = pd.read_csv(str(sys.argv[2]))

df2 = pd.DataFrame()
df2["Student name"] = dfc["Student"]
df2["ID"] = dfc["ID"]
df2["Student ID"] = dfc["SIS User ID"]
df2["Final Points"] = dfc["Final Points"]
df2["Final Score"] = dfc["Final Score"]

max_points = round(float(df2["Final Points"].max()), 2)
df2["Risk"] = (float(sys.argv[3]) - (df2["Final Points"] / max_points) * 100).round(2)
pd.set_option('display.max_rows', 10)

df2 = df2.sort_values(by=['Risk'], ascending=False)

df3 = pd.DataFrame()
df3["Participation total"] = dfz.loc[:, dfz.columns.str.match("(Participation total)(?!.time)(.+)")]
df3["Challenge total"] = dfz.loc[:, dfz.columns.str.match("(Challenge total)(?!.time)(.+)")]
df3["Lab total"] = dfz.loc[:, dfz.columns.str.match("(Lab total)(?!.time)(.+)")]
df3

stats = {'Student count': len(df2),
        'At risk': float((df2['Risk'] > 30).sum()),
         'Points average': float(df2['Final Points'].mean().round(2)),
         'Score average': float(df2['Final Score'].mean().round(2)),
         'Participation average': float(df3['Participation total'].mean().round(2)),
         'Challenge average': float(df3['Challenge total'].mean().round(2)),
         'Lab average': float(df3['Lab total'].mean().round(2)),
        }
stats

stats_json = json.dumps(stats)

print(stats_json)