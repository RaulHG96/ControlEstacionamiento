import { Component, OnInit, OnDestroy, HostListener } from '@angular/core';
import { environment } from 'src/environments/environment';
import { Subscription } from 'rxjs';
import { DataService } from 'src/app/services/data.service';
import { SecurityService } from 'src/app/services/security.service';
import { IResponse } from 'src/app/models/iresponse';
import { ILogin } from 'src/app/models/ilogin';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  subRef$: Subscription;

  constructor(
    private dataService: DataService,
    private securityService: SecurityService
  ) {
    this.securityService.LogOff();
  }
  /**
   * Se inicia sesión para obtener token para conexión con el api
   */
  LoginApi() {
    const usuarioLogin: ILogin = {
      email: environment.email,
      password: environment.password
    }

    const urlApi = environment.urlAPI + 'login';
    this.subRef$ = this.dataService.post<IResponse>(urlApi, usuarioLogin).subscribe(res => {
      const token = res.body?.token;
      this.securityService.SetAuthData(token);
    }, err => {
      console.log('Error en el login', err);
    });
  }
  /**
   * Se destruye la la instancia que escucha las respuestas
   */
  ngOnDestroy() {
    if (this.subRef$) {
      this.subRef$.unsubscribe();
    }
  }
}
