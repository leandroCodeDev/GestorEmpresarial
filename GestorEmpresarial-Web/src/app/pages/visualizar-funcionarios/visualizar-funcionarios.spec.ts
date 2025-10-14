import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VisualizarFuncionarios } from './visualizar-funcionarios';

describe('VisualizarFuncionarios', () => {
  let component: VisualizarFuncionarios;
  let fixture: ComponentFixture<VisualizarFuncionarios>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VisualizarFuncionarios]
    })
    .compileComponents();

    fixture = TestBed.createComponent(VisualizarFuncionarios);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
