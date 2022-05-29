import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'menu-opciones',
  templateUrl: './menu-opciones.component.html',
  styleUrls: ['./menu-opciones.component.css']
})
export class MenuOpcionesComponent implements OnInit {
  botones = [{
    'textoHTML': 'Registrar entrada',
    'classIcon': 'fa-solid fa-2x fa-arrow-right-to-bracket',
    'classButton': 'btn-registra-entrada',
    'link': '/registra-entrada',
    'hasEvent': '0',
    'function': ''
  }, {
    'textoHTML': 'Registrar salida',
    'classIcon': "fa-solid fa-2x fa-arrow-right-from-bracket",
    'classButton': 'btn-registra-salida',
    'link': '/registra-salida',
    'hasEvent': '0',
    'function': ''
  }, {
    'textoHTML': 'Alta vehículo oficial',
    'classIcon': "fa-solid fa-2x fa-car-rear",
    'classButton': 'btn-alta-oficial',
    'link': '/registra-vehiculo-oficial',
    'hasEvent': '0',
    'function': ''
  }, {
    'textoHTML': 'Alta vehículo residente',
    'classIcon': "fa-solid fa-2x fa-car-on",
    'classButton': 'btn-alta-residente',
    'link': '/registra-vehiculo-residente',
    'hasEvent': '0',
    'function': ''
  }, {
    'textoHTML': 'Comienza mes',
    'classIcon': "fa-solid fa-2x fa-calendar-day",
    'classButton': 'btn-comienza-mes',
    'link': '/',
    'hasEvent': '1',
    'function': 'initMonth'
  }, {
    'textoHTML': 'Generar informe de pagos de residentes',
    'classIcon': "fa-solid fa-2x fa-file-invoice-dollar",
    'classButton': 'btn-pago-residentes',
    'link': '/',
    'hasEvent': '1',
    'function': 'generateReport'
  }];
  constructor() { }

  ngOnInit(): void {
  }
}
