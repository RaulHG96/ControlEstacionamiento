import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Subscription } from 'rxjs';
import { environment } from 'src/environments/environment';
import Swal from 'sweetalert2';
import { IPlaca } from '../models/iplaca';
import { IResponseApi } from '../models/iresponse-api';
import { DataService } from '../services/data.service';
import { SecurityService } from '../services/security.service';

@Component({
  selector: 'app-form-vehiculo-oficial',
  templateUrl: './form-vehiculo-oficial.component.html',
  styleUrls: ['./form-vehiculo-oficial.component.css']
})
export class FormVehiculoOficialComponent implements OnInit {
  formRegistroOficial: FormGroup;
  subRef$: Subscription;
  inputplaca = '';
  
  constructor(
    private formBuilder: FormBuilder,
    private dataService: DataService,
    private securityService: SecurityService
  ) {
    this.securityService.LogOff();
    this.formRegistroOficial = this.formBuilder.group({
      numPlacas: [null, [Validators.required]]
    });
  }

  ngOnInit(): void {
  }

  onSubmit() {
    Swal.fire({
      title: 'Registrando vehículo, espere por favor...'
    });
    Swal.showLoading();
    const numPlacas: IPlaca = {
      numPlaca: this.formRegistroOficial.value.numPlacas
    }
    const urlApi = environment.urlAPI + 'registraVehiculoOficial';
    this.subRef$ = this.dataService.post<IResponseApi>(urlApi, numPlacas).subscribe(res => {
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
            title: 'Se registró correctamente vehículo oficial'
          });
          this.inputplaca = '';
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
      console.log('Error al registrar vehiculo', err);
    });
  }
  
  ngOnDestroy() {
    if (this.subRef$) {
      this.subRef$.unsubscribe();
    }
  }
}
