import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditarEmpresas } from './editar-empresas';

describe('EditarEmpresas', () => {
  let component: EditarEmpresas;
  let fixture: ComponentFixture<EditarEmpresas>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EditarEmpresas]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditarEmpresas);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
