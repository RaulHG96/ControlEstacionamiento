import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormVehiculoResidenteComponent } from './form-vehiculo-residente.component';

describe('FormVehiculoResidenteComponent', () => {
  let component: FormVehiculoResidenteComponent;
  let fixture: ComponentFixture<FormVehiculoResidenteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormVehiculoResidenteComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormVehiculoResidenteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
