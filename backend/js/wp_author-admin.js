jQuery(document).ready(function() {
	var author_gallery_frame;
	
	// For upload image gallery, multi images
	jQuery('#author_gallery_button').click(function(e){e.preventDefault();

		// If the frame already exists, re-open it.
		if ( author_gallery_frame ) {
				author_gallery_frame.open();
				return;
		}

		// Sets up the media library frame
		author_gallery_frame = wp.media.frames.author_gallery_frame = wp.media({
				title: author_gallery.title,
				button: { text:  author_gallery.button },
				library: { type: 'image' },
				multiple: 'add' // For select multiple
		});

		// Create Featured Gallery state. This is essentially the Gallery state, but selection behavior is altered.
		author_gallery_frame.states.add([
			new wp.media.controller.Library({
				id:         'authors-gallery',
				title:      'Select Images for Gallery',
				priority:   20,
				toolbar:    'main-gallery',
				filterable: 'uploaded',
				library:    wp.media.query( author_gallery_frame.options.library ),
				multiple:   author_gallery_frame.options.multiple ? 'reset' : false,
				editable:   true,
				allowLocalEdits: true,
				displaySettings: true,
				displayUserSettings: true
			}),
		]);

		author_gallery_frame.on('open', function() {
			var selection = author_gallery_frame.state().get('selection');
			var library = author_gallery_frame.state('gallery-edit').get('library');
			var ids = jQuery('#author_gallery').val();
			if (ids) {
				idsArray = ids.split(',');
				idsArray.forEach(function(id) {
					attachment = wp.media.attachment(id);
					attachment.fetch();
					selection.add( attachment ? [ attachment ] : [] );
				});
			}
		}); 
	
		// When an image is selected, run a callback.
		author_gallery_frame.on('select', function() {
			var imageIDArray = [];
			var imageHTML = '';
			var metadataString = '';
			images = author_gallery_frame.state().get('selection');
			
			console.log(images);
			
			imageHTML += '<ul class="author_gallery_list">';
			images.each(function(attachment) {
				console.debug(attachment.attributes);
				imageIDArray.push(attachment.attributes.id);
				if (typeof attachment.attributes.sizes.thumbnail === 'undefined') {
					imageHTML += '<li><div class="author_gallery_container"><span id="'+attachment.attributes.id+'" class="author_gallery_close"></span><img id="close-id'+attachment.attributes.id+'" src="'+attachment.attributes.url+'"></div></li>';
				} else {
					imageHTML += '<li><div class="author_gallery_container"><span id="'+attachment.attributes.id+'" class="author_gallery_close"></span><img id="close-id'+attachment.attributes.id+'" src="'+attachment.attributes.sizes.thumbnail.url+'"></div></li>';
				}
			});
			imageHTML += '</ul>';
			metadataString = imageIDArray.join(",");
			if (metadataString) {
				jQuery("#author_gallery").val(metadataString);
				jQuery("#author_gallery_src").html(imageHTML);
			}
		});
	 
		// Finally, open the modal
		author_gallery_frame.open();
		//console.log(3);
		
	  });

	jQuery(document.body).on('click', '.author_gallery_close', function(event){event.preventDefault();
	  if (confirm('Are you sure you want to remove this image?')) {
			var removedImage = jQuery(this).attr('id');
			var oldGallery = jQuery("#author_gallery").val();
			var newGallery = oldGallery.replace(','+removedImage,'').replace(removedImage+',','').replace(removedImage,'');
			jQuery(this).parents().eq(1).remove();
			jQuery("#author_gallery").val(newGallery);
		}
	});
  });