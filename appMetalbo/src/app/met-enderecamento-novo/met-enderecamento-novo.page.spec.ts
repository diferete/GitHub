import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { MetEnderecamentoNovoPage } from './met-enderecamento-novo.page';

describe('MetEnderecamentoNovoPage', () => {
  let component: MetEnderecamentoNovoPage;
  let fixture: ComponentFixture<MetEnderecamentoNovoPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MetEnderecamentoNovoPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(MetEnderecamentoNovoPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
