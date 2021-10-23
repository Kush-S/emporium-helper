import sys
import pandas as pd

data_frame = pd.read_csv(str(sys.argv[1]))

json = data_frame[['Last name', 'First name', 'School email']].to_json()
print(json)
