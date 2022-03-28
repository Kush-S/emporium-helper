import pandas as pd
import sys

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
df2['Risk'] = 100 - (df2['Participation total'] / 20 + df2['Challenge total'] / 20 + df2['Lab total'] / 1.11)

json = df2.to_json(orient='index')

print(json)
