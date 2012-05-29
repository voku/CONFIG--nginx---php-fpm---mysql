#!/bin/bash

if [-n "`clamscan --infected --nosummary $1`" ]; then
   echo 0;
else
   echo 1;
fi
