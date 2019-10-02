<?php


//Keep the total number of points
$totalPoints = 0;

//Keep the total score
$totalScore = 0;

//Keep the total number of missed points
$totalMissed = 0;

//Keep a variable for the report output
$report = "";

//Go into a loop until the user exits
while (true)    {
    //Prompt the user
    echo "Please enter a command in the form of (a, r, q) :";

    //Read in the command
    $cmd = stream_get_line(STDIN, 1024, PHP_EOL);
    //If the command is ....
    switch($cmd)
    {
        //If quit then quit.
        case "q":
            echo "\nBye!\n";
            exit();
        break;

        //Prompt the user for assessment details
        case "a":
            //Enter the name of the assessment
            echo "Please enter the name of the assessment: ";
            $assName = stream_get_line(STDIN, 1024, PHP_EOL);     
            //Enter the number of points for the assessment
            echo "Please enter the number of points for the assessment: ";
            $assessmentPoints = stream_get_line(STDIN, 1024, PHP_EOL);
            //Check if the user was absent, keep asking until the user enters a y or a n.
            do {
                echo "Was the student absent? (y/n) ";
                $absent = stream_get_line(STDIN, 1024, PHP_EOL);
            } while($absent != "y" && $absent != "n");
            
            //If the student was absent
            if ($absent == "y")    {
                
                //Write a message to the console
                echo "The student has been maked absent for this assignment.\n";
                //add the missed points to the total
                $totalMissed +=  $assessmentPoints;
                
                //Set the score to zero
                $assessmentScore = 0;
            
            } else {

                echo "Please enter the student's score for the assessment: ";
                $assessmentScore = stream_get_line(STDIN, 1024, PHP_EOL);

            }

            //Update the totals (Points and Score)
            $totalPoints += $assessmentPoints;
            $totalScore += $assessmentScore;

            //Start the Report we have all the data we need
            //print seperator
            $report .= sprintf("%'-80s\n",'');
            //Append the assignment name
            $report .= sprintf("%20s %40s\n","Assignment:",$assName);
            //Append the Total Points
            $report .= sprintf("%20s %40s\n","Total Points:",$assessmentPoints);
            //Append the Total Score
            $report .= sprintf("%20s %40s\n","Total Score:",$assessmentScore);
            //Append the Missed
            $report .= sprintf("%20s %40s\n","Missed:",$absent);
            //Append seperator
            $report .= sprintf("%'-80s\n",'');
        break;

        
        //If print the report.
        case "r":

             //Compile the final Report
            
             //Calculated the weighted average
             $weightedAvg = $totalScore / $totalPoints;

             //Calculate the missed percentage
             $missedP = $totalMissed / $totalPoints;
             //Was it a UN?
            if($missedP >= 0.30)
                $un = true;
            else
            {
                if($weightedAvg >= 0.50)
                $un = false;
                else
                $un = true;
            }

                //if not
                if($un == false)
                    //PASS
                    $outcome = "PASS";
                 else
                    //FAIL
                    $outcome = "FAIL";
                 
            //Print seperator
            $finalReport = sprintf("%'-80s\n",'');
            
            $finalReport .= sprintf("%40s","FINAL REPORT")."\n";
            //Print the weighted average
            $finalReport .=sprintf("%20s %36s%0.2f%%\n","Weighted Average:","",$weightedAvg);
            //Print the missed percentage
            $finalReport .=sprintf("%20s %36s%0.2f%%\n","Missed Percentage:","",$missedP);
            //Print outcome final outcome
            $finalReport .=sprintf("%20s %40s\n","Outcome:",$outcome);
            //Print seperator
            $finalReport .= sprintf("%'-80s\n",'');
            
             
             echo $report;
             echo $finalReport;

        break;

            //Hit the default? Cant recognize the command?
        default:
             echo "Please enter a valid command\n";
        break;
    }

}

?>