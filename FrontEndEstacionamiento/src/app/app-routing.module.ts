import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { FormEntradaComponent } from './form-entrada/form-entrada.component';
import { FormSalidaComponent } from './form-salida/form-salida.component';
import { MenuOpcionesComponent } from './menu-opciones/menu-opciones.component';
import { FormVehiculoOficialComponent } from './form-vehiculo-oficial/form-vehiculo-oficial.component';
import { FormVehiculoResidenteComponent } from './form-vehiculo-residente/form-vehiculo-residente.component';

const routes: Routes = [{
  path: '',
  component: MenuOpcionesComponent
},{
  path: 'registra-entrada',
  component: FormEntradaComponent
},{
  path: 'registra-salida',
  component: FormSalidaComponent
},{
  path: 'registra-vehiculo-oficial',
  component: FormVehiculoOficialComponent
},{
  path: 'registra-vehiculo-residente',
  component: FormVehiculoResidenteComponent
}];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
