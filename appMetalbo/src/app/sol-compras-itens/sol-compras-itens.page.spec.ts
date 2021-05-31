import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { SolComprasItensPage } from './sol-compras-itens.page';

describe('SolComprasItensPage', () => {
  let component: SolComprasItensPage;
  let fixture: ComponentFixture<SolComprasItensPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SolComprasItensPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(SolComprasItensPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
