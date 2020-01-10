import { Injectable, ComponentFactoryResolver, Injector, Inject } from '@angular/core';
import { MatDialog, MatDialogConfig, MatDialogRef } from '@angular/material';
import { DOCUMENT } from '@angular/common';
import { ConfirmationDialogComponent } from '../components/confirmation-dialog/confirmation-dialog.component';

@Injectable({
  providedIn: 'root'
})
export class ModalService {

  constructor(
    public dialog: MatDialog,
  ) {}

  open(component, config) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = config;

    this.dialog.open(component, dialogConfig).afterClosed().subscribe(data => {
      console.log(data);
    });
  }

  openConfirmationDialog(text: string, config) {
    const dialogConfig = new MatDialogConfig();

    dialogConfig.autoFocus = true;

    dialogConfig.data = config;

    this.dialog.open(ConfirmationDialogComponent, config);
  }
}
