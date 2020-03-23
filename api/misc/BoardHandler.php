<?php

namespace app\misc;

use Yii;
use yii\base\BaseObject;

class BoardHandler extends BaseObject
{
    const STATUS_COMPLETED_LINE = 'line';
    const STATUS_NO_MOVES_LEFT = 'no_moves_left';

    const DIMENSION = 3;
    const EMPTY_CHARACTER = '-';

    /**
     * @var string
     */
    public $board;

    /**
     * @var string
     */
    protected $newBoard;

    /**
     * @var Array
     */
    private $newBoardArr;
    /**
     * @var Array
     */
    private $boardArr;

    /**
     * @var Array
     */
    private $boardNewMoves;

    public $moveCharacterMap = [
        1 => 'X', // odd
        0 => '0', // even
    ];

    public function init()
    {
        $this->boardArr = str_split($this->board);
    }

    public function changeState(string $newBoard)
    {
        $this->newBoard = $newBoard;
        $this->newBoardArr = str_split($this->newBoard);

        $this->boardNewMoves = array_diff_assoc($this->newBoardArr, $this->boardArr);

        $this->changeStateCheck();
        $this->setBoardFromArr($this->newBoardArr);
    }

    protected function changeStateCheck()
    {
        // Make sure 1 move has been made.
        if (empty($this->boardNewMoves)) {
            throw new BoardException(Yii::t('app', 'No move detected.'));
        }
        // Make sure 1 move has been made.
        if (count($this->boardNewMoves) > 1) {
            throw new BoardException(Yii::t('app', 'Only one move per request allowed.'));
        }

        // Make sure proper character used.
        $allowedCharacter = $this->moveCharacterMap[($this->getTotalMoves() + 1) % 2];
        if (($moveCharacter = $this->getNewMoveCharacter()) != $allowedCharacter) {
            throw new BoardException(Yii::t('app', 'You have to use character "{allowedCharacter}" instead of "{moveCharacter}"', [
                'allowedCharacter' => $allowedCharacter,
                'moveCharacter' => $moveCharacter,
            ]));
        }

        // Make sure that character has been placed into the proper position (not overriding existing).
        if (in_array($this->boardArr[$this->getNewMovePosition()], $this->moveCharacterMap)) {
            throw new BoardException(Yii::t('app', 'You are not allowed to override existing moves.'));
        }
    }

    private function getNewMovePosition()
    {
        return key($this->boardNewMoves);
    }

    private function getNewMoveCharacter()
    {
        return current($this->boardNewMoves);
    }

    private function getTotalMoves()
    {
        $emptyBoardArr = self::getEmptyBoardArr();
        return count(array_diff($this->boardArr, $emptyBoardArr));
    }

    static private function getEmptyBoardArr()
    {
        return array_fill(0, self::DIMENSION * self::DIMENSION, self::EMPTY_CHARACTER);
    }

    static public function getEmptyBoard()
    {
        return implode('', self::getEmptyBoardArr());
    }

    private function setBoardFromArr(array $array)
    {
        $this->boardArr = $array;
        $this->board = implode('', $array);
    }

    public function makeRandomMove()
    {
        $allowedCharacter = $this->moveCharacterMap[($this->getTotalMoves() + 1) % 2];
        $allowedMovePositions = array_intersect_assoc(self::getEmptyBoardArr(), $this->boardArr);
        $movePosition = array_rand($allowedMovePositions);
        $this->boardArr[$movePosition] = $allowedCharacter;
        $this->setBoardFromArr($this->boardArr);
    }

    /**
     * Check if there is a completed line.
     * @return boolean
     */
    public function hasLine()
    {
        $linesHorizontal = $linesVertical = [];

        $n = 0;
        for ($i = 0; $i < self::DIMENSION; $i++) {
            for ($j = 0; $j < self::DIMENSION; $j++) {
                $char = $this->boardArr[$n];
                if ($this->fillDirection($linesHorizontal, $char, $i)) {
                    return TRUE;
                }
                if ($this->fillDirection($linesVertical, $char, $j)) {
                    return TRUE;
                }
                $n++;
            }
        }

        // Left diagonal check.
        $leftDiagonal = [];
        for ($l = 0; $l < self::DIMENSION * self::DIMENSION; $l = $l + self::DIMENSION + 1) {
            $char = $this->boardArr[$l];
            if ($this->fillDirection($leftDiagonal, $char)) {
                return TRUE;
            }
        }

        // Right diagonal check.
        $rightDiagonal = [];
        for ($r = self::DIMENSION - 1; $r < self::DIMENSION * self::DIMENSION - (self::DIMENSION - 1); $r = $r + self::DIMENSION - 1) {
            $char = $this->boardArr[$r];
            if ($this->fillDirection($rightDiagonal, $char)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getStatus()
    {
        if ($this->hasLine()) {
            return self::STATUS_COMPLETED_LINE;
        }
        if ($this->getTotalMoves() == self::DIMENSION * self::DIMENSION) {
            return self::STATUS_NO_MOVES_LEFT;
        }
    }

    /**
     * @param Array $direction
     * @param string $char
     * @param null|int $n
     * @return boolean|null Returns TRUE if direction of dimension length is filled with one char.
     */
    private function fillDirection(&$direction, $char, $n = null)
    {
        if ($char == self::EMPTY_CHARACTER) {
            return;
        }
        if (isset($n)) {
            if (empty($direction[$n])) {
                $direction[$n] = [];
            }
            $direction = &$direction[$n];
        }
        if (empty($direction[$char])) {
            $direction[$char] = 1;
        } else {
            $direction[$char]++;
        }
        if ($direction[$char] == self::DIMENSION) {
            return TRUE;
        }
    }
}
