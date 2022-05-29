import { Component, OnInit, Input } from '@angular/core';
import { Subscription } from 'rxjs';
import { environment } from 'src/environments/environment';
import Swal from 'sweetalert2';
import { IResponseApi } from '../models/iresponse-api';
import { IResponseFile } from '../models/iresponse-file';
import { DataService } from '../services/data.service';
import { SecurityService } from '../services/security.service';

@Component({
  selector: 'boton-opcion',
  templateUrl: './boton-opcion.component.html',
  styleUrls: ['./boton-opcion.component.css']
})
export class BotonOpcionComponent implements OnInit {
  @Input() boton:any;
  subRef$: Subscription;
  constructor(
    private dataService: DataService,
    private securityService: SecurityService
  ) {
    this.securityService.LogOff();
  }

  ngOnInit(): void {
    
  }

  initMonth() {
    Swal.fire({
      title: '¿Realmente desea reiniciar los contadores del mes?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: 'Aceptar',
      denyButtonText: `Cancelar`,
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Reiniciando conteo mes, espere por favor...'
        });
        Swal.showLoading();
        const urlApi = environment.urlAPI + 'reiniciaMes';
        this.subRef$ = this.dataService.post<IResponseApi>(urlApi, {}).subscribe(res => {
          if(res.body?.success) {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })
            Toast.fire({
              icon: 'success',
              title: 'Se reinició correctamente los contadores del mes'
            });
          } else {
            let msj = '';
            (res.body?.error).forEach((element: string)=> {
              msj += `<li>${element}</li>`;
            });
            Swal.fire({
                title: '¡Atención!',
                html: msj,
                icon: 'info',
                allowEscapeKey: false,
                confirmButtonText: 'Aceptar',
                allowOutsideClick: false
            });
          }
        }, err => {
          console.log('Error al reiniciar mes', err);
        });
      }
    });
  }

  generateReport() {
    // generaArchivoReporte
    Swal.fire({
      title: 'Ingresa el nombre del archivo a generar:',
      input: 'text',
      confirmButtonText: 'Aceptar',
      showCancelButton: true,
      cancelButtonText: `Cancelar`,
    }).then((result) => {
      if(result.isConfirmed) {
        const urlApi = environment.urlAPI.replace('api/','') + `generaArchivoReporte/${result.value}`;
        var link = document.createElement('a');
        link.href = urlApi;
        link.download = result.value;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }
    });
  }
  /**
   * Función encargada de dirigir la petición del cliente a su función correspondiente
   * @param funcion String con el nombre de la función a llamar
   */
  goFunction(funcion: string) {
    switch(funcion) {
      case 'initMonth':
        this.initMonth();
        break;
      case 'generateReport':
        this.generateReport();
        break;
      case 'default':
        console.error('La función a la que se intenta llamar no existe');
        break;
    }
  }
}
