import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VisualizarEmpresas } from './visualizar-empresas';

describe('VisualizarEmpresas', () => {
  let component: VisualizarEmpresas;
  let fixture: ComponentFixture<VisualizarEmpresas>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VisualizarEmpresas]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VisualizarEmpresas);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
