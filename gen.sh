#!/usr/bin/env bash

############################################################################
######################### Command Generator ################################
############################################################################
############################################################################

for i in "$@"
do
case $i in
        -c=*|command=*)
        command="${i#*=}"
    ;;
        -n=*|namespace=*)
        namespace="${i#*=}"
    ;;
        -h*|help=*)
	    echo To generate a command you must enter a command name with no spaces.
		echo Example
		echo command=testing namespace=foo_bar
	;;
    *)
		# unknown option
        echo see help
    ;;
esac
done

if [ ${command} ]; then

php src/generate.php command=${command} namespace=${namespace}
else
	    echo To generate a command you must enter a command name with no spaces.
		echo Example
		echo command=testing namespace=foo_bar
fi

exit;