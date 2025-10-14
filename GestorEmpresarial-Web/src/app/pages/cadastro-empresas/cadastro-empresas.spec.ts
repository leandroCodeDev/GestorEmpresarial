import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CadastroEmpresas } from './cadastro-empresas';

describe('CadastroEmpresas', () => {
  let component: CadastroEmpresas;
  let fixture: ComponentFixture<CadastroEmpresas>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CadastroEmpresas]
    })
    .compileComponents();

    fixture = TestBed.createComponent(CadastroEmpresas);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
