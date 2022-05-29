import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BotonOpcionComponent } from './boton-opcion/boton-opcion.component';
import { FormEntradaComponent } from './form-entrada/form-entrada.component';
import { FormSalidaComponent } from './form-salida/form-salida.component';
import { FormVehiculoOficialComponent } from './form-vehiculo-oficial/form-vehiculo-oficial.component';
import { FormVehiculoResidenteComponent } from './form-vehiculo-residente/form-vehiculo-residente.component';
import { MenuOpcionesComponent } from './menu-opciones/menu-opciones.component';
import { HttpClientModule } from '@angular/common/http';
import { SweetAlert2Module } from '@sweetalert2/ngx-sweetalert2';

@NgModule({
  declarations: [
    AppComponent,
    BotonOpcionComponent,
    FormEntradaComponent,
    FormSalidaComponent,
    FormVehiculoOficialComponent,
    FormVehiculoResidenteComponent,
    MenuOpcionesComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    SweetAlert2Module.forRoot()
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule { }
