import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BotonOpcionComponent } from './boton-opcion.component';

describe('BotonOpcionComponent', () => {
  let component: BotonOpcionComponent;
  let fixture: ComponentFixture<BotonOpcionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ BotonOpcionComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(BotonOpcionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
