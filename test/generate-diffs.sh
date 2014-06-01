# Generates diff data from repo commits

# Save pwd and then change dir to the script location
STARTDIR=`pwd`
cd `dirname $0`

git show 11ecdc1a8ba9a13fdb212d7788af1b79d81e90a7 > diffs/add-lines1

git show 0c8bc141825f8a7b40db6bf121984586386ae7fe > diffs/del-lines1

git show b720096ea7a3ceab3cf566c75678ef079ea758e2 > diffs/add-del1

# Go back to original dir
cd $STARTDIR 
