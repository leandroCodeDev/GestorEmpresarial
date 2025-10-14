import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastroClientes } from './cadastro-clientes';

describe('CadastroClientes', () => {
  let component: CadastroClientes;
  let fixture: ComponentFixture<CadastroClientes>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CadastroClientes]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CadastroClientes);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
