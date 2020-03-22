import { Component, OnInit, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { Game } from 'src/app/models/game';

@Component({
  selector: 'app-game-result',
  templateUrl: './game-result.component.html',
  styleUrls: ['./game-result.component.scss']
})
export class GameResultComponent {

  constructor(
    private dialogRef: MatDialogRef<GameResultComponent>,
    @Inject(MAT_DIALOG_DATA) public game: Game
  ) { }

  dismiss() {
    this.dialogRef.close();
  }

}
