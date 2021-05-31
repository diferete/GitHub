import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { SolComprasPage } from './sol-compras.page';

describe('SolComprasPage', () => {
  let component: SolComprasPage;
  let fixture: ComponentFixture<SolComprasPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SolComprasPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(SolComprasPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
