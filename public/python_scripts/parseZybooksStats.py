import pandas as pd
import sys
import json

df = pd.read_csv(str(sys.argv[1]))

df2 = pd.DataFrame()
df2["First name"] = df["First name"]
df2["Last name"] = df["Last name"]
df2["Primary email"] = df["Primary email"]
df2["School email"] = df["School email"]
df2["Student ID"] = df["Student ID"]

# Get only participation/challenge/lab total columns, not the time ones
df2["Participation total"] = df.loc[:, df.columns.str.match("(Participation total)(?!.time)(.+)")]
df2["Challenge total"] = df.loc[:, df.columns.str.match("(Challenge total)(?!.time)(.+)")]
df2["Lab total"] = df.loc[:, df.columns.str.match("(Lab total)(?!.time)(.+)")]

# Calculate risk of each student based on participation, challenge, and lab grade
df2['Risk'] = (((float(sys.argv[2])*df2['Participation total'] + float(sys.argv[3])) / float(sys.argv[4])) + ((float(sys.argv[5])*df2['Challenge total'] + float(sys.argv[6])) /float(sys.argv[7])) + ((float(sys.argv[8])*df2['Lab total']+float(sys.argv[9])) /float(sys.argv[10]))).round(2)

stats = {'Student count': len(df2),
         'At risk': float((df2['Risk'] > 30).sum()),
         'Participation average': float(df2['Participation total'].mean().round(2)),
         'Challenge average': float(df2['Challenge total'].mean().round(2)),
         'Lab average': float(df2['Lab total'].mean().round(2))
        }
stats_json = json.dumps(stats)

print(stats_json)
