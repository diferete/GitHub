import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { MetEnderecamentoPage } from './met-enderecamento.page';

describe('MetEnderecamentoPage', () => {
  let component: MetEnderecamentoPage;
  let fixture: ComponentFixture<MetEnderecamentoPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MetEnderecamentoPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(MetEnderecamentoPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
