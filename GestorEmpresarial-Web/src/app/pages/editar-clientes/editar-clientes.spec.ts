import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditarClientes } from './editar-clientes';

describe('EditarClientes', () => {
  let component: EditarClientes;
  let fixture: ComponentFixture<EditarClientes>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EditarClientes]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EditarClientes);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
