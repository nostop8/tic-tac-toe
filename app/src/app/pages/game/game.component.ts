import { Component, OnInit, ViewChild } from '@angular/core';
import { BoardComponent } from 'src/app/components/board/board.component';
import { GameService } from 'src/app/services/game.service';
import { trigger, state, style, transition, animate } from '@angular/animations';
import { Game } from 'src/app/models/game';
import { MatDialog, MatDialogRef } from '@angular/material/dialog';
import { GameResultComponent } from 'src/app/components/game-result/game-result.component';

@Component({
  selector: 'app-game',
  templateUrl: './game.component.html',
  styleUrls: ['./game.component.scss'],
  animations: [
    trigger('openClose', [
      state('open', style({
        height: '400px',
        opacity: 1,
      })),
      state('closed', style({
        height: '0',
        opacity: 0,
      })),
      transition('open => closed', [
        animate('0.3s')
      ]),
      transition('closed => open', [
        animate('0.3s')
      ]),
    ]),
  ]
})
export class GameComponent implements OnInit {

  isOpen = false;
  game = new Game;
  modalRef: MatDialogRef<GameResultComponent>;

  @ViewChild(BoardComponent) board: BoardComponent;

  constructor(
    private gameService: GameService,
    private dialog: MatDialog,
  ) { }

  ngOnInit(): void {
  }

  start() {
    this.isOpen = true;
    this.game = new Game;
    this.game.board = '---------';
    this.board.create();
  }

  cellClicked(cellIndex: number) {
    if (this.game.board.charAt(cellIndex) != '-') {
      return;
    }

    this.game.board = this.game.board.substr(0, cellIndex) + 'X' + this.game.board.substr(cellIndex + 1);
    let promise: Promise<Game>;
    if (this.game.id) {
      promise = this.gameService.update(this.game)
    } else {
      promise = this.gameService.create(this.game);
    }
    promise.then(game => {
      setTimeout(() => {
        this.updateGame(game);
      }, 500);
    });
  }

  updateGame(game: Game) {
    Object.assign(this.game, game);
    if (this.game.status != 'RUNNING') {
      this.modalRef = this.dialog.open(GameResultComponent, {
        width: '400px',
        data: this.game,
      });
      this.modalRef.afterClosed().subscribe(() => {
        this.game = new Game();
        this.isOpen = false;
      });
    }
  }

}
