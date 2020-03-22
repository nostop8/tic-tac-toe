import { Component, OnInit, Output, EventEmitter, Input, OnChanges } from '@angular/core';
import { BoardCell } from 'src/app/models/board-cell';

@Component({
  selector: 'app-board',
  templateUrl: './board.component.html',
  styleUrls: ['./board.component.scss']
})
export class BoardComponent implements OnInit, OnChanges {

  readonly dimension = 3;

  public cells: BoardCell[] = [];

  @Input() board: string;
  @Output('cellClicked') cellClicked = new EventEmitter();

  constructor() { }

  ngOnInit(): void {
    // this.create();
  }

  ngOnChanges() {
    if (!this.board) {
      return;
    }
    for (let i = 0; i < this.board.length; i++) {
      this.cells[i].char = this.board.charAt(i);
    }
  }

  create() {
    this.cells = [];
    for (let i = 0; i < this.dimension * this.dimension; i++) {
      this.cells.push(new BoardCell);
    }
  }

  click(cellIndex: number) {
    this.cellClicked.emit(cellIndex);
  }

}
