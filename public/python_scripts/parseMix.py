import pandas as pd
import sys

df = pd.read_csv(str(sys.argv[1]), skiprows=[1])

df2 = pd.DataFrame()
df2["Student name"] = df["Student"]
df2["ID"] = df["ID"]
df2["SIS User ID"] = df["SIS User ID"]
df2["SIS Login ID"] = df["SIS Login ID"]
df2["Final Points"] = df["Final Points"]
df2["Final Score"] = df["Final Score"]

# Create max_points variable which gets the max points currently from list of students
max_points = round(float(df2["Final Points"].max()), 2)

# Calculate the risk from max_points
df2["Risk"] = (float(sys.argv[3]) - (df2["Final Points"] / max_points) * 100).round(2)

# Sort students by max risk
df2 = df2.sort_values(by=['Risk'], ascending=False)

# Convert and print data frame as JSON
df2 = df2.to_json(orient='index')

print(df2)