#!/bin/python

import csv
import sys
import os


csv_file = os.path.dirname(sys.argv[0]) + "/Saved_Commands.csv"
csv_tmp_file = os.path.dirname(sys.argv[0]) + "/Saved_Commands-tmp.csv"
command_to_delete = str(sys.argv[1])


def csvDel(cmd):

    reader = csv.reader(open(csv_file, "rb"), delimiter=',')
    f = csv.writer(open(csv_tmp_file, "wb"))
    for line in reader:
        if cmd not in line:
            f.writerow(line)

    os.unlink(csv_file)
    os.rename(csv_tmp_file, csv_file)

csvDel(command_to_delete)
