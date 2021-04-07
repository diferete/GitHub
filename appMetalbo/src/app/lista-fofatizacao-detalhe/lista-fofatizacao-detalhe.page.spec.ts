import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ListaFofatizacaoDetalhePage } from './lista-fofatizacao-detalhe.page';

describe('ListaFofatizacaoDetalhePage', () => {
  let component: ListaFofatizacaoDetalhePage;
  let fixture: ComponentFixture<ListaFofatizacaoDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListaFofatizacaoDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ListaFofatizacaoDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
