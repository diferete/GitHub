import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ListProdutosPage } from './list-produtos.page';

describe('ListProdutosPage', () => {
  let component: ListProdutosPage;
  let fixture: ComponentFixture<ListProdutosPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ListProdutosPage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ListProdutosPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
