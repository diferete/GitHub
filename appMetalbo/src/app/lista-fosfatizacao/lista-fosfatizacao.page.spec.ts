import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ListaFosfatizacaoPage } from './lista-fosfatizacao.page';

describe('ListaFosfatizacaoPage', () => {
  let component: ListaFosfatizacaoPage;
  let fixture: ComponentFixture<ListaFosfatizacaoPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListaFosfatizacaoPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ListaFosfatizacaoPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
