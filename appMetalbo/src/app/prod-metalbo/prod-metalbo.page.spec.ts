import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ProdMetalboPage } from './prod-metalbo.page';

describe('ProdMetalboPage', () => {
  let component: ProdMetalboPage;
  let fixture: ComponentFixture<ProdMetalboPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ProdMetalboPage ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ProdMetalboPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
