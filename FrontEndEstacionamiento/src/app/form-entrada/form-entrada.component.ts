import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Subscription } from 'rxjs';
import { environment } from 'src/environments/environment';
import Swal from 'sweetalert2';
import { IPlaca } from '../models/iplaca';
import { IResponseApi } from '../models/iresponse-api';
import { DataService } from '../services/data.service';
import { SecurityService } from '../services/security.service';

@Component({
  selector: 'form-entrada',
  templateUrl: './form-entrada.component.html',
  styleUrls: ['./form-entrada.component.css']
})
export class FormEntradaComponent implements OnInit, OnDestroy {
  formRegistroEntrada: FormGroup;
  subRef$: Subscription;
  inputplaca = '';
  
  constructor(
    private formBuilder: FormBuilder,
    private dataService: DataService,
    private securityService: SecurityService
  ) {
    this.securityService.LogOff();
    this.formRegistroEntrada = this.formBuilder.group({
      numPlacas: [null, [Validators.required]]
    });
  }

  ngOnInit(): void {
  }

  onSubmit() {
    Swal.fire({
      title: 'Registrando entrada, espere por favor...'
    });
    Swal.showLoading();
    const numPlacas: IPlaca = {
      numPlaca: this.formRegistroEntrada.value.numPlacas
    }
    const urlApi = environment.urlAPI + 'registraEntrada';
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
          title: 'Se registró correctamente hora de entrada'
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
      console.log('Error al registrar entrada', err);
    });
  }

  ngOnDestroy() {
    if (this.subRef$) {
      this.subRef$.unsubscribe();
    }
  }
}
