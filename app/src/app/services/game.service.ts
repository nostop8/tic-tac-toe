import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Game } from '../models/game';

@Injectable({
  providedIn: 'root'
})
export class GameService {

  constructor(
    private httpClient: HttpClient
  ) { }

  create(data: Game) {
    return this.httpClient.post(environment.apiUrl + 'games', data).toPromise() as Promise<Game>;
  }

  update(data: Game) {
    return this.httpClient.put(environment.apiUrl + `games/${data.id}`, data).toPromise() as Promise<Game>;
  }
}
