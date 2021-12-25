import pandas
import sys

data_frame = pandas.read_csv(str(sys.argv[1]))

json = data_frame[['Last name', 'First name', 'Primary email']].to_json(orient='index')
print(json)
