import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { IonicModule } from '@ionic/angular';

import { ModalItensAntigosComponent } from './modal-itens-antigos.component';

describe('ModalItensAntigosComponent', () => {
  let component: ModalItensAntigosComponent;
  let fixture: ComponentFixture<ModalItensAntigosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ModalItensAntigosComponent ],
      imports: [IonicModule.forRoot()]
    }).compileComponents();

    fixture = TestBed.createComponent(ModalItensAntigosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  }));

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
