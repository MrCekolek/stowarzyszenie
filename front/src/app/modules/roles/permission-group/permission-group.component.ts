import { Component, OnInit, Input } from '@angular/core';

@Component({
  selector: 'app-permission-group',
  templateUrl: './permission-group.component.html',
  styleUrls: ['./permission-group.component.scss']
})
export class PermissionGroupComponent implements OnInit {

  @Input() permissionGroupObj;

  constructor() { }

  ngOnInit() {
  }

  // click event on parent checkbox
  parentClick(parentObj) {
    for (let i = 0; i < parentObj.permissions.length; i++) {
      parentObj.permissions[i].selected = parentObj.isSelected;
    }
  }

  // click event on child checkbox
  childClick(parentObj, childObj) {
    parentObj.isSelected = parentObj.permissions.every(function (itemChild: any) {
      return itemChild.selected == true;
    })
  }

  // collapse event on parent
  expandCollapse(obj){
    obj.isClosed = !obj.isClosed;
  }
}
