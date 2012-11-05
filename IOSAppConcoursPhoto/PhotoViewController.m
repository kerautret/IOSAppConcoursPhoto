//
//  PhotoViewController.m
//  IOSAppConcoursPhoto
//
//  Created by Kerautret on 05/11/12.
//  Copyright (c) 2012 projetTutoreSRC. All rights reserved.
//

#import "PhotoViewController.h"

#define COOKBOOK_PURPLE_COLOR	[UIColor colorWithRed:0.20392f green:0.19607f blue:0.61176f alpha:1.0f]
#define BARBUTTON(TITLE, SELECTOR) 	[[UIBarButtonItem alloc] initWithTitle:TITLE style:UIBarButtonItemStylePlain target:self action:SELECTOR]
#define RESIZABLE(_VIEW_)   [_VIEW_ setAutoresizingMask:UIViewAutoresizingFlexibleHeight | UIViewAutoresizingFlexibleWidth]
#define IS_IPHONE (UI_USER_INTERFACE_IDIOM() == UIUserInterfaceIdiomPhone)



CGPoint CGRectGetCenter(CGRect rect)
{
    CGPoint pt;
    pt.x = CGRectGetMidX(rect);
    pt.y = CGRectGetMidY(rect);
    return pt;
}
@implementation PhotoViewController
// Update image and for iPhone, dismiss the controller
- (void)imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info
{
    UIImage *image = [info objectForKey:UIImagePickerControllerEditedImage];
    if (!image)
        image = [info objectForKey:UIImagePickerControllerOriginalImage];
        imageView.image = image;
        
        UIImageWriteToSavedPhotosAlbum(image, self, @selector(image:didFinishSavingWithError:contextInfo:), nil);
        
        if (IS_IPHONE)
        {
            [self dismissModalViewControllerAnimated:YES];
            imagePickerController = nil;
        }
}

// Dismiss picker
- (void) imagePickerControllerDidCancel: (UIImagePickerController *)picker
{
    [self dismissModalViewControllerAnimated:YES];
    imagePickerController = nil;
}

// Popover was dismissed
- (void)popoverControllerDidDismissPopover:(UIPopoverController *)aPopoverController
{
	imagePickerController = nil;
    popoverController = nil;
}

- (IBAction) snapImage: (id) sender
{
    // Create an initialize the picker
	imagePickerController = [[UIImagePickerController alloc] init];
    imagePickerController.sourceType =  UIImagePickerControllerSourceTypeCamera;
    imagePickerController.allowsEditing = editSwitch.isOn;
	imagePickerController.delegate = self;
	
	if (IS_IPHONE)
	{
        [self presentModalViewController:imagePickerController animated:YES];
	}
	else
	{
        if (popoverController) [popoverController dismissPopoverAnimated:NO];
        popoverController = [[UIPopoverController alloc] initWithContentViewController:imagePickerController];
        popoverController.delegate = self;
        [popoverController presentPopoverFromBarButtonItem:self.navigationItem.rightBarButtonItem permittedArrowDirections:UIPopoverArrowDirectionAny animated:YES];
	}
}

- (void)image:(UIImage *)image didFinishSavingWithError: (NSError *)error contextInfo:(void *)contextInfo;
{
    // Handle the end of the image write process
    if (!error)
        NSLog(@"Image written to photo album");
        else
            NSLog(@"Error writing to photo album: %@", [error localizedDescription]);
            }

- (void) loadView
{
    [super loadView];
    self.view.backgroundColor = [UIColor whiteColor];
    RESIZABLE(self.view);
    
    imageView = [[UIImageView alloc] init];
    imageView.contentMode = UIViewContentModeScaleAspectFit;
    RESIZABLE(imageView);
    [self.view addSubview:imageView];
    
    editSwitch = [[UISwitch alloc] init];
    self.navigationItem.titleView = editSwitch;
    
	self.navigationController.navigationBar.tintColor = COOKBOOK_PURPLE_COLOR;
    
    if ([UIImagePickerController isSourceTypeAvailable:
         UIImagePickerControllerSourceTypeCamera])
        self.navigationItem.rightBarButtonItem = BARBUTTON(@"Snap", @selector(snapImage:));
        else
            self.title = @"Camera not available";
            }

- (void) viewDidAppear:(BOOL)animated
{
    imageView.frame = self.view.bounds;
    imageView.center = CGRectGetCenter(self.view.bounds);
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
	return YES;
}

@end
