import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormVehiculoOficialComponent } from './form-vehiculo-oficial.component';

describe('FormVehiculoOficialComponent', () => {
  let component: FormVehiculoOficialComponent;
  let fixture: ComponentFixture<FormVehiculoOficialComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormVehiculoOficialComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormVehiculoOficialComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
