import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ProdSteelPage } from './prod-steel.page';

describe('ProdSteelPage', () => {
  let component: ProdSteelPage;
  let fixture: ComponentFixture<ProdSteelPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProdSteelPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ProdSteelPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
