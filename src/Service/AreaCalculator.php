<?php
namespace App\Service;

class AreaCalculator
{

    const X_SIZE = 20;
    const Y_SIZE = 15;

    // xy positions of 1s in 20x15 2-dimensional matrix
    private $aData;

    // 20x15 2-dimensional matrix of values (either 1 or 0)
    private $aBinaryMatrix = [];

    // Number of selected dots
    private $iNumberOfSelectedDots = 0;

    // Array containing all found rectangles
    private $aFoundRectangles = [];

    public function __construct(array $aData)
    {
        $this->aData = $aData;
    }


    /**
     * Creates a matrix filled with ones and zeroes
     */
    public function createBinaryMatrix()
    {
        // fill matrix with zeros
        $this->aBinaryMatrix = array_fill(0, 20, array_fill(0, 15, 0));

        // fill matrix with ones
        foreach ($this->aData as $iXYPair) {
            $iX = $iXYPair['x'];
            $iY = $iXYPair['y'];

            $this->aBinaryMatrix[$iX][$iY] = 1;
            $this->iNumberOfSelectedDots++;
        }
    }


    /**
     * Find all bounding areas that are formed consecutively from the selected dots in the matrix.
     */
    public function findRectangleCoordinates()
    {
        $aMatrix = $this->aBinaryMatrix;
        // used to create temporary found positions array
        $index = -1;


        for ($i = 0; $i < AreaCalculator::X_SIZE; $i++) {
            for ($j = 0; $j < AreaCalculator::Y_SIZE; $j++) {
                if ($aMatrix[$i][$j] == 1) {

                    /*
                        $aPositions[0] = starting x position
                        $aPositions[1] = starting y position
                        $aPositions[2] = ending x position
                        $aPositions[3] = ending y position
                        $aPositions[4] = size of found rectangle
                    */
                    $aPositions = [$i, $j]; // save starting position of rectangle area
                    $aResults[] = $this->findRectangleEndCoordinates($i, $j, $aMatrix, $aPositions);

                    // see how the algorithm works
                    //$this->aBinaryMatrix = $aMatrix;
                    //$this->printBinaryMatrix();
                }
            }
        }

        $this->aFoundRectangles = $aResults;
    }

    /**
     * @param int $i             - $i x-position in array where a one was found
     * @param int $j             - $j y-position in array where a one was found
     * @param array $aMatrix     - the search array
     * @param array $aPositions  - the result array where the found rectangles are stored
     *
     * @return array $aPositions - found rectangle starting ending xy-coords and size of rectangle
     */
    private function findRectangleEndCoordinates(int $i, int $j, array &$aMatrix, array $aPositions)
    {

        $x = AreaCalculator::X_SIZE-1;
        $y = AreaCalculator::Y_SIZE-1;

        // flag to check column edge case, initializing with 0
        $iColumnEdgeCase = 0;

        // flag to check row edge case, initializing with 0
        $iRowEdgeCase = 0;

        foreach (range($i, $x) as $m) {
            # loop breaks when first zero is encountered
            if ($aMatrix[$m][$j] == 0) {
                $iRowEdgeCase = 1; # set row flag
                break;
            }

            foreach (range($j, $y) as $n) {
                // loop breaks when first zero encounters
                if ($aMatrix[$m][$n] == 0) {
                    // set the flag
                    $iColumnEdgeCase = 1;
                    break;
                }
            }
        }

        // take care of edge cases
        if ($iRowEdgeCase == 1) {
            $aPositions[] = $m - 1;
        } else {
            $aPositions[] = $m;
        }

        if ($iColumnEdgeCase == 1) {
            $aPositions[] = $n - 1;
        } else {
            $aPositions[] = $m;
        }

        /* update matrix, set already found rectangle values to zero
           count size of found rectangles
           update result array with size value */
        $iRectangleSizeCounter = 0;
        foreach (range($aPositions[0],$aPositions[2]) as $xDelete) {
            foreach (range($aPositions[1],$aPositions[3]) as $yDelete) {
                $aMatrix[$xDelete][$yDelete] = 0;
                $iRectangleSizeCounter++;
            }
        }

        $aPositions[4] = $iRectangleSizeCounter;

        return $aPositions;
    }


    /**
     * Find the the bounding area of the currently largest rectangle (by covered area) that can be formed consecutively from the selected dots in the matrix.
     */
    public function printLargestRectangle() {
        // sort resulting array by size - position 4 contains size
        usort($this->aFoundRectangles, function ($item1, $item2) {
            return $item2[4] <=> $item1[4];
        });

        echo 'Largest found rectangle has coordinates: '  . PHP_EOL;
        echo 'x start: ' . $this->aFoundRectangles[0][0]  . PHP_EOL;
        echo 'y start: ' . $this->aFoundRectangles[0][1]  . PHP_EOL;
        echo 'x end: ' . $this->aFoundRectangles[0][2]    . PHP_EOL;
        echo 'y end : ' . $this->aFoundRectangles[0][3]   . PHP_EOL;
        echo 'and size: ' . $this->aFoundRectangles[0][4] . PHP_EOL;
    }


    /**
     * Print binary matrix
     */
    public function printBinaryMatrix()
    {
        for ($i = 0; $i < 20; $i++) {
            for ($k = 0; $k < 15; $k++) {
                echo $this->aBinaryMatrix[$i][$k];
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }


    /**
     * Print number of selected dots in current matrix
     */
    public function printNumberOfSelectedDots()
    {
        echo 'Current number of selected dots is ' . $this->iNumberOfSelectedDots . PHP_EOL;
    }

}