//
//  PhotoViewController.h
//  IOSAppConcoursPhoto
//
//  Created by Kerautret on 05/11/12.
//  Copyright (c) 2012 projetTutoreSRC. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface PhotoViewController : UIViewController<UINavigationControllerDelegate,UIImagePickerControllerDelegate,UIPopoverControllerDelegate>{
    
    UIImageView *imageView;
    UISwitch *editSwitch;
    UIPopoverController *popoverController;
    UIImagePickerController *imagePickerController;
    IBOutlet UIButton *photoLanch;
    
}

@end
