import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { MetEnderecamentoDetalhePage } from './met-enderecamento-detalhe.page';

describe('MetEnderecamentoDetalhePage', () => {
  let component: MetEnderecamentoDetalhePage;
  let fixture: ComponentFixture<MetEnderecamentoDetalhePage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MetEnderecamentoDetalhePage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(MetEnderecamentoDetalhePage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
